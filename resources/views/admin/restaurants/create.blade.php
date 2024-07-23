<x-master-layout>
    <div class="container mt-5 p-4">
        <h4>Create Restaurant</h4>
        <form action="{{ route('admin.restaurants.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="mb-3">
                <label for="about" class="form-label">About</label>
                <textarea class="form-control" id="about" name="about"></textarea>
            </div>
            <div class="mb-3">
                <label for="logo" class="form-label">Logo</label>
                <input type="file" class="form-control" id="logo" name="logo">
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number">
            </div>
            <div class="mb-3">
                <label for="website_url" class="form-label">Website URL</label>
                <input type="url" class="form-control" id="website_url" name="website_url">
            </div>
            <div class="mb-3">
                <label for="facebook_url" class="form-label">Facebook URL</label>
                <input type="url" class="form-control" id="facebook_url" name="facebook_url">
            </div>
            <div class="mb-3">
                <label for="instagram_url" class="form-label">Instagram URL</label>
                <input type="url" class="form-control" id="instagram_url" name="instagram_url">
            </div>
            <div class="mb-3">
                <label for="linkedin_url" class="form-label">LinkedIn URL</label>
                <input type="url" class="form-control" id="linkedin_url" name="linkedin_url">
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>
</x-master-layout>
