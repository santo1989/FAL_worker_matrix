<!DOCTYPE html>
<html>
<head>
    <title>Report Builder</title>
    <style>
        .container { display: flex; gap: 20px; padding: 20px; }
        .field-list, .selected-fields, .config-box { 
            border: 1px solid #ccc; 
            padding: 15px; 
            min-height: 400px;
            width: 300px;
        }
        .field-item {
            padding: 8px;
            margin: 5px;
            background: #f0f0f0;
            cursor: move;
            border-radius: 4px;
        }
        .config-sections { display: flex; gap: 20px; margin-top: 20px; }
        .order-item { display: flex; justify-content: space-between; align-items: center; margin: 5px 0; }
        .delete-btn { color: red; cursor: pointer; margin-left: 10px; }
        .direction-btn { cursor: pointer; }
        .groupby-available { margin-top: 10px; border-top: 1px solid #ccc; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="field-list">
            <h3>Available Fields</h3>
            <div id="availableFields">
                @foreach($fields as $table => $columns)
                    <div class="table-group">
                        <strong>{{ $table }}</strong>
                        @foreach($columns as $column)
                            <div class="field-item" draggable="true" 
                                 data-table="{{ $table }}" 
                                 data-column="{{ $column }}">
                                {{ $column }}
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="selected-fields" id="selectedFields" 
             ondragover="allowDrop(event)" 
             ondrop="drop(event)">
            <h3>Selected Fields</h3>
            <div id="selectedItems"></div>
        </div>

        <div class="config-sections">
            <div class="config-box" id="groupByArea">
                <h3>Group By <button type="button" onclick="clearGroupBy()">Clear</button></h3>
                <div class="groupby-available" id="groupByAvailable"
                     ondragover="allowDrop(event)" 
                     ondrop="dropGroupBy(event)">
                    <h4>Available for Grouping</h4>
                    <div id="groupByOptions"></div>
                </div>
                <div id="activeGroupByFields"></div>
            </div>
            
            <div class="config-box" id="orderByArea" ondragover="allowDrop(event)" ondrop="dropOrderBy(event)">
                <h3>Order By <button type="button" onclick="clearOrderBy()">Clear</button></h3>
                <div id="orderByFields"></div>
            </div>
        </div>
    </div>

    <button style="margin: 20px;" onclick="generateReport()">Generate Report</button>
    {{-- <button onclick="saveConfig()">Save Configuration</button> --}}
    <!--back button-->
    <a href="{{ route('home') }}" class="btn btn-primary" style="margin: 20px;">Back</a>

    <script>
        let selectedFields = [];
        let groupByFields = [];
        let orderByFields = [];

        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("table", ev.target.dataset.table);
            ev.dataTransfer.setData("column", ev.target.dataset.column);
        }

        // Selected Fields Drop
        function drop(ev) {
            ev.preventDefault();
            const table = ev.dataTransfer.getData("table");
            const column = ev.dataTransfer.getData("column");
            
            if(!selectedFields.find(f => f.table === table && f.column === column)) {
                selectedFields.push({ table, column });
                updateAllDisplays();
            }
        }

        // Group By Drop
        function dropGroupBy(ev) {
            ev.preventDefault();
            const table = ev.dataTransfer.getData("table");
            const column = ev.dataTransfer.getData("column");
            
            if(isValidGroupByField(table, column)) {
                if(!groupByFields.find(f => f.table === table && f.column === column)) {
                    groupByFields.push({ table, column });
                    updateAllDisplays();
                }
            }
        }

        function isValidGroupByField(table, column) {
            return selectedFields.some(f => f.table === table && f.column === column);
        }

        // Order By Drop
        function dropOrderBy(ev) {
            ev.preventDefault();
            const table = ev.dataTransfer.getData("table");
            const column = ev.dataTransfer.getData("column");
            const direction = prompt('Enter sort direction (ASC/DESC):', 'ASC')?.toUpperCase();
            
            if(direction && ['ASC', 'DESC'].includes(direction)) {
                if(!orderByFields.find(f => f.table === table && f.column === column)) {
                    orderByFields.push({ table, column, direction });
                    updateAllDisplays();
                }
            }
        }

        // Update all displays
        function updateAllDisplays() {
            updateSelectedDisplay();
            updateGroupByDisplay();
            updateOrderByDisplay();
        }

        function updateSelectedDisplay() {
            const container = document.getElementById('selectedItems');
            container.innerHTML = selectedFields
                .map(f => `
                    <div class="field-item" draggable="true" ondragstart="drag(event)"
                         data-table="${f.table}" data-column="${f.column}">
                        ${f.column} (${f.table})
                        <span class="delete-btn" onclick="removeField('${f.table}', '${f.column}')">×</span>
                    </div>
                `).join('');
            
            updateGroupByOptions();
        }

        function updateGroupByOptions() {
            const container = document.getElementById('groupByOptions');
            container.innerHTML = selectedFields
                .filter(f => !groupByFields.some(gf => gf.table === f.table && gf.column === f.column))
                .map(f => `
                    <div class="field-item" draggable="true" ondragstart="drag(event)"
                         data-table="${f.table}" data-column="${f.column}">
                        ${f.column} (${f.table})
                    </div>
                `).join('');
        }

        function updateGroupByDisplay() {
            const container = document.getElementById('activeGroupByFields');
            container.innerHTML = groupByFields
                .map(f => `
                    <div class="field-item">
                        ${f.column} (${f.table})
                        <span class="delete-btn" onclick="removeGroupByField('${f.table}', '${f.column}')">×</span>
                    </div>
                `).join('');
        }

        function updateOrderByDisplay() {
            const container = document.getElementById('orderByFields');
            container.innerHTML = orderByFields
                .map((f, index) => `
                    <div class="order-item">
                        <span>${f.column} (${f.table})</span>
                        <div>
                            <span class="direction-btn" onclick="toggleOrderDirection(${index})">${f.direction}</span>
                            <span class="delete-btn" onclick="removeOrderByField(${index})">×</span>
                        </div>
                    </div>
                `).join('');
        }

        // Remove handlers
        function removeField(table, column) {
            selectedFields = selectedFields.filter(f => !(f.table === table && f.column === column));
            groupByFields = groupByFields.filter(f => !(f.table === table && f.column === column));
            orderByFields = orderByFields.filter(f => !(f.table === table && f.column === column));
            updateAllDisplays();
        }

        function removeGroupByField(table, column) {
            groupByFields = groupByFields.filter(f => !(f.table === table && f.column === column));
            updateAllDisplays();
        }

        function removeOrderByField(index) {
            orderByFields.splice(index, 1);
            updateOrderByDisplay();
        }

        function toggleOrderDirection(index) {
            orderByFields[index].direction = orderByFields[index].direction === 'ASC' ? 'DESC' : 'ASC';
            updateOrderByDisplay();
        }

        // Clear handlers
        function clearGroupBy() {
            groupByFields = [];
            updateAllDisplays();
        }

        function clearOrderBy() {
            orderByFields = [];
            updateOrderByDisplay();
        }

        // Generate Report
        async function generateReport() {
            const fields = selectedFields.map(f => `${f.table}.${f.column}`);
            const groupBy = groupByFields.map(f => `${f.table}.${f.column}`);
            const orderBy = orderByFields.map(f => ({
                column: `${f.table}.${f.column}`,
                direction: f.direction
            }));

            const response = await fetch('/generate-report', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ fields, groupBy, orderBy })
            });

            const data = await response.json();
            
            // Convert to CSV
            const csvContent = [
                data.fields.join(','),
                ...data.rows.map(row => data.fields.map(f => row[f] ?? '').join(','))
            ].join('\n');

            // Download CSV
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'report.csv';
            link.click();
        }

        // Save/Load Configurations
        function saveConfig() {
            const configName = prompt('Enter configuration name:');
            if(configName) {
                const config = {
                    selectedFields,
                    groupByFields,
                    orderByFields
                };
                localStorage.setItem(configName, JSON.stringify(config));
            }
        }

        // Initialize
        document.querySelectorAll('.field-item').forEach(item => {
            item.addEventListener('dragstart', drag);
        });
    </script>
</body>
</html>