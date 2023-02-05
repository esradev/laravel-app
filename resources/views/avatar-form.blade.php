<x-layout doctitle="Manage Your Avatar">
    <div class="container container--narrow py-md-5">
        <h2 class="text-center mb-3">Upload a New Avatar</h2>
        <form action="/manage-avatar" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <input type="file" name="avatar">
            @error('avatar')
                <p class="alert small alert-danger shadow-sm">{{$message}}</p>
            @enderror
        </div>
        <button class="btn btn-brimary">Save</button>
        </form>
    </div>
</x-layout>
