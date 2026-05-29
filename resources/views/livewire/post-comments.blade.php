<div>
    <!-- Comments List -->
    <div class="mb-12 space-y-6">
        @forelse($post->comments()->where('approved', true)->get() as $comment)
            <div class="border-l-4 border-blue-600 pl-6 py-4">
                <p class="font-semibold">{{ $comment->name }}</p>
                <p class="text-sm text-gray-500 mb-2">{{ $comment->created_at->diffForHumans() }}</p>
                <p class="text-gray-700">{{ $comment->content }}</p>
            </div>
        @empty
            <p class="text-gray-500">No comments yet. Be the first to comment!</p>
        @endforelse
    </div>

    <!-- Add Comment Form -->
    <form wire:submit.prevent="submit" class="bg-gray-50 p-8 rounded-lg">
        <h3 class="font-bold text-lg mb-6">Leave a Comment</h3>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Name</label>
            <input 
                type="text" 
                wire:model="name" 
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Email</label>
            <input 
                type="email" 
                wire:model="email" 
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Comment</label>
            <textarea 
                wire:model="content" 
                required
                rows="5"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            ></textarea>
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button 
            type="submit" 
            class="btn-primary"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Post Comment</span>
            <span wire:loading>Posting...</span>
        </button>
    </form>
</div>
