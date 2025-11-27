<x-backend.layouts.master>
    <div class="card">
        <div class="card-header">Approver Settings (Admin only)</div>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.approvers.update') }}">
                @csrf

                <div class="mb-3">
                    <label for="role_select" class="form-label">Approver Roles</label>
                    <select id="role_select" name="role_ids[]" class="form-select" multiple style="width:100%">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ in_array($role->id, $selectedRoleIds) ? 'selected' : '' }}>{{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">Select roles that should be considered approvers. Members of these roles will
                        receive approval requests.</div>
                </div>

                <div class="mb-3">
                    <label for="user_select" class="form-label">Individual Approvers (searchable)</label>
                    <select id="user_select" name="user_ids[]" class="form-select" multiple style="width:100%">
                        @php
                            $usersByRole = [];
                            foreach ($users as $u) {
                                $roleName = $u->role->name ?? 'Other';
                                $usersByRole[$roleName][] = $u;
                            }
                        @endphp

                        @foreach ($usersByRole as $roleName => $group)
                            <optgroup label="{{ $roleName }}">
                                @foreach ($group as $u)
                                    <option value="{{ $u->id }}"
                                        {{ in_array($u->id, $selectedUserIds) ? 'selected' : '' }}>{{ $u->name }} —
                                        {{ $u->email }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <div class="form-text">Pick individual users as overrides (optional). Use search to find users
                        quickly.</div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function() {
            if (typeof $ === 'undefined' || typeof $.fn.select2 === 'undefined') return;

            $('#role_select').select2({
                placeholder: 'Select approver roles',
                allowClear: true,
                width: 'resolve'
            });

            $('#user_select').select2({
                placeholder: 'Search and select individual approvers',
                allowClear: true,
                width: 'resolve'
            });
        })();
    </script>

</x-backend.layouts.master>
<x-backend.layouts.master>
    <div class="card">
        <div class="card-header">Approver Settings (Admin only)</div>
        <div class="card-body">
            <form method="POST" action="{{ route('settings.approvers.update') }}">
                @csrf
                <h6>Roles</h6>
                <div class="row">
                    @foreach ($roles as $role)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="role_ids[]"
                                    value="{{ $role->id }}" id="role_{{ $role->id }}"
                                    {{ in_array($role->id, $selectedRoleIds) ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="role_{{ $role->id }}">{{ $role->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <hr>
                <h6>Users (individual overrides)</h6>
                <div class="row">
                    @foreach ($users as $user)
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="user_ids[]"
                                    value="{{ $user->id }}" id="user_{{ $user->id }}"
                                    {{ in_array($user->id, $selectedUserIds) ? 'checked' : '' }}>
                                <label class="form-check-label" for="user_{{ $user->id }}">{{ $user->name }}
                                    ({{ $user->email }})
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-backend.layouts.master>
