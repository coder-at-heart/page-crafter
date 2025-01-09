@extends('layouts.admin.app')

@section('page-title', $mode === 'edit' ? 'Edit Page' : 'Create New Page')

@section('back', route('admin.pagecraft.index'))

@section('content')
  @component('admin.components.section',[
      'header' => $mode === 'edit' ? 'Edit Page: '. $page->title : 'Create New Page',
  ])
        <div id="pagecraft-editor"
             data-components='{{ json_encode($components) }}'
             data-mode="{{ $mode }}"
             data-token="{{ csrf_token() }}"
             data-save_url="{{ route('admin.pagecraft.update', $page) }}"
             data-destroy_url="{{ route('admin.pagecraft.destroy', $page) }}"
             data-statuses="{{  json_encode(\App\Modules\Pagecraft\Enums\PageStatus::getValues()) }}"
             data-fixed="{{ $fixed }}"
             data-page='{{ json_encode($page, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) }}'>
        </div>
  @endcomponent
@endsection
