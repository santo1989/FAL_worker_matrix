<x-backend.layouts.master>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">Notifications</h5>
            <div>
                <a href="#" id="markAllReadBtn" class="btn btn-sm btn-primary">Mark all read</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Message</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notifications as $n)
                        <tr @if (isset($n->status) && $n->status == 'unread') class="table-warning" @endif>
                            <td>{{ $n->message }}</td>
                            <td>{{ $n->type }}</td>
                            <td>{{ optional($n->created_at)->format('Y-m-d H:i') }}</td>
                            <td>
                                @if (isset($n->status) && $n->status == 'unread')
                                    <button class="btn btn-sm btn-success mark-read" data-id="{{ $n->id }}">Mark
                                        read</button>
                                @else
                                    <button class="btn btn-sm btn-secondary mark-unread"
                                        data-id="{{ $n->id }}">Mark unread</button>
                                @endif
                                <a href="{{ $n->link ?? '#' }}" class="btn btn-sm btn-info">Open</a>
                                <button class="btn btn-sm btn-outline-danger ms-1 delete-notification"
                                    data-id="{{ $n->id }}">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $notifications->links() }}
        </div>
    </div>

    <script>
        (function() {
            var token = document.querySelector('meta[name="csrf-token"]') ? document.querySelector(
                'meta[name="csrf-token"]').getAttribute('content') : null;

            function post(url, data, cb) {
                data = data || {};
                data._token = token;
                $.post(url, data, cb);
            }

            $('.mark-read').on('click', function() {
                var id = $(this).data('id');
                post("{{ url('/notification') }}/" + id + "/mark-read", {}, function() {
                    location.reload();
                });
            });
            $('.mark-unread').on('click', function() {
                var id = $(this).data('id');
                post("{{ url('/notification') }}/" + id + "/mark-unread", {}, function() {
                    location.reload();
                });
            });

            $('.delete-notification').on('click', function(e) {
                e.preventDefault();
                if (!confirm('Delete this notification?')) return;
                var id = $(this).data('id');
                post("{{ url('/notification') }}/" + id + "/delete", {}, function() {
                    location.reload();
                });
            });

            $('#markAllReadBtn').on('click', function(e) {
                e.preventDefault();
                post("{{ route('notification.markAllRead') }}", {}, function() {
                    location.reload();
                });
            });
        })();
    </script>
</x-backend.layouts.master>
