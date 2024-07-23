<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>Edit Restaurant</h4>
        <form action="{{ route('admin.restaurants.update', $restaurant->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $restaurant->title }}" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $restaurant->address }}" required>
            </div>
            <div class="mb-3">
                <label for="about" class="form-label">About</label>
                <textarea class="form-control" id="about" name="about">{{ $restaurant->about }}</textarea>
            </div>
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" class="form-control" id="logo" name="logo">
                @if($restaurant->logo)
                    <img src="{{ asset('storage/' . $restaurant->logo) }}" alt="Logo" width="100">
                @endif
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $restaurant->phone_number }}">
            </div>
            <div class="mb-3">
                <label for="website_url" class="form-label">Website URL</label>
                <input type="url" class="form-control" id="website_url" name="website_url" value="{{ $restaurant->website_url }}">
            </div>
            <div class="mb-3">
                <label for="facebook_url" class="form-label">Facebook URL</label>
                <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="{{ $restaurant->facebook_url }}">
            </div>
            <div class="mb-3">
                <label for="instagram_url" class="form-label">Instagram URL</label>
                <input type="url" class="form-control" id="instagram_url" name="instagram_url" value="{{ $restaurant->instagram_url }}">
            </div>
            <div class="mb-3">
                <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                <input type="url" class="form-control" id="linkedin_url" name="linkedin_url" value="{{ $restaurant->linkedin_url }}">
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</x-master-layout>
