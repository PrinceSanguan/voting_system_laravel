<select class="form-control rounded-0" name="organization" wire:poll.keep-alive>
  <option value="">Choose Here...</option>
  @foreach($data as $key)
  <option value="{{ $key->Organization }}">{{ $key->Organization }}</option>
  @endforeach
</select>