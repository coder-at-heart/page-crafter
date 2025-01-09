@extends('layouts.admin.app')

@section('page-title', 'Pagecraft')

@section('content')
    @component('admin.components.section', [
        'header' => 'Manage pages',
        'create' => route('admin.pagecraft.create'),
    ])
        <table id="article-data-table" class="table data-table">
            <thead>
            <th width="10px" data-searchable="false">#</th>
            <th>Title</th>
            <th>Type</th>
            <th>Status</th>
            <th data-orderable="false" data-searchable="false">Last Updated</th>
            <th >Last Updated</th>
            </thead>
            <tbody>
            @foreach($pages as $page)
                <tr>
                    <td>{{ $page->id }}</td>
                    <td>{{ $page->title }}</td>
                    <td>{{ $page->template }}</td>
                    <td>{{ $page->status }}</td>
                    <td>{{ $page->updated_at }}</td>
                    <td>
                        <form action="{{ route('admin.pagecraft.edit', $page) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-info">Edit</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endcomponent
@endsection

@push('js')
    <script>
        $('.js-delete-article').click(function (e) {
            e.preventDefault()

            if (confirm('This action cannot be undone, are you sure you want to continue?')) {
                $(this).closest('form').submit()
            }
        })
    </script>
@endpush
