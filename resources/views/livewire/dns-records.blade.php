<div>
    <form wire:submit.prevent="{{ $recordId ? 'updateRecord' : 'createRecord' }}" class="mb-4">
        <div class="flex space-x-2">
            <input type="text" wire:model.defer="type" placeholder="Type" class="border p-1">
            <input type="text" wire:model.defer="name" placeholder="Name" class="border p-1">
            <input type="text" wire:model.defer="value" placeholder="Value" class="border p-1">
            <input type="number" wire:model.defer="ttl" placeholder="TTL" class="border p-1">
            <button type="submit" class="bg-blue-500 text-white px-2 py-1">{{ $recordId ? 'Update' : 'Add' }}</button>
            @if($recordId)
                <button type="button" wire:click="$set('recordId', null)" class="px-2 py-1">Cancel</button>
            @endif
        </div>
        @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @error('value') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        @error('ttl') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </form>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border px-2">Type</th>
                <th class="border px-2">Name</th>
                <th class="border px-2">Value</th>
                <th class="border px-2">TTL</th>
                <th class="border px-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $r)
                <tr>
                    <td class="border px-2">{{ $r->type }}</td>
                    <td class="border px-2">{{ $r->name }}</td>
                    <td class="border px-2">{{ $r->value }}</td>
                    <td class="border px-2">{{ $r->ttl }}</td>
                    <td class="border px-2 space-x-2">
                        <button wire:click="editRecord({{ $r->id }})" class="text-blue-500">Edit</button>
                        <button wire:click="deleteRecord({{ $r->id }})" class="text-red-500">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
