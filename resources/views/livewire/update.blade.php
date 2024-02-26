<div class="card">
    <div class="card-body">
        <form>
            <h3>Update Post: {{$this->title}}</h3>
            <hr>
            <div class="form-group mb-3">
                <label for="title">Title:</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter Title" wire:model="title">
                @error('title') 
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="description">Description:</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" wire:model="description" placeholder="Enter Description"></textarea>
                @error('description') 
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="gap-2 text-center">
                <button wire:click.prevent="updateOldPost()" class="btn btn-success btn-block">Update</button>
                <button wire:click.prevent="cancel()" class="btn btn-secondary btn-block">Cancel</button>
            </div>
        </form>
    </div>
</div>
