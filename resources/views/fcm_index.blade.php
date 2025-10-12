@extends('backend.layouts.app')

@section('content')
<div class="card">

<div class="card-header">
    <div class="row align-items-center">
        <!-- Col 3: Title -->
        <div class="col-3">
            <h5 class="mb-0">FCM Notifications</h5>
        </div>

        <!-- Col 6: Search box -->
        <div class="col-6">
            <form method="GET" action="{{ route('backend.settings.fcm.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by title or message" value="{{ request('search') }}">
                    <button class="btn btn-dark" type="submit">Search</button>
                </div>
            </form>
        </div>

        <!-- Col 3: Create button -->
        <div class="col-3 text-end">
            <a href="{{ route('backend.settings.fcm.create') }}" class="btn btn-primary">
                <i class="ph ph-plus-circle"></i> Create Notification
            </a>
        </div>
    </div>
</div>


    <div class="card-body">

        

        @if($notifications->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $notification)
                            <tr>
                                <td>{{ $loop->iteration + ($notifications->currentPage()-1)*$notifications->perPage() }}</td>
                                <td>{{ $notification->title }}</td>
                                <td>{{ $notification->message }}</td>
                                <td>{{ $notification->created_at->format('d M, Y') }}</td>
                                <td>
                                    <form action="{{ route('backend.settings.fcm.destroy', $notification->id) }}" method="POST" class="d-inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $notifications->links() }}
                </div>
            </div>
        @else
            <p class="text-center text-muted">No FCM notifications found.</p>
        @endif

    </div>
</div>
@endsection

@push('after-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Success message popup
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    @endif

    // Confirm before delete
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
