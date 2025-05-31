@extends('layouts.app')

@section('content')
    <h1>Events</h1>
    <a href="{{ route('event.create') }}">Create Event</a>
    
    <ul>
        @foreach ($event as $event)
            <li>
                {{ $event->name }} 
                <a href="{{ route('event.edit', $event) }}">Edit</a> 
                <form action="{{ route('event.destroy', $event) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
