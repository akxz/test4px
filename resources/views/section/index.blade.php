@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Sections') }}
                    <a class="btn btn-primary float-right btn-sm" href="{{ url('section/create') }}">{{ __('Add') }}</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                    @endif


                    <table class="table">
                      <tbody>
                        @foreach ($sections as $section)
                        <tr id="tr{{ $section->id }}">
                            <td><img src="{{ url('/logo/' . $section->logo) }}" alt="{{ $section->name }}" /></td>
                            <td class="w40">
                                <b>{{ $section->name }}</b><br />
                                {{ $section->description }}
                            </td>
                            <td>
                                @if (count($section->users) > 0)
                                    <b>{{ __('Users') }}</b>
                                    <ol>
                                    @foreach ($section->users as $user)
                                    <li>{{ $user->name }}</li>
                                    @endforeach
                                </ol>
                                @endif
                            </td>
                            <td><a class="btn btn-secondary btn-sm" href="{{ url('section/edit/' . $section->id) }}">{{ __('Edit') }}</a>
                            <btn-delete :section="{{ $section->id }}" ></btn-delete>
                            </td>
                        </tr>
                        @endforeach

                      </tbody>
                    </table>


                    {{ $sections->links() }}

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __('Delete section info') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">{{ __('Do you want to delete this?') }}</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
        <confirm-delete></confirm-delete>
     </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
const ConfirmDelete = Vue.component('confirm-delete', {
    template: '<button type="button" class="btn btn-primary" data-dismiss="modal"   @click="deleteSection()">{{ __('Yes') }}</button>',
    // props: ['user'],
    methods: {
        deleteSection() {
            if (localStorage.id) {
                // alert('DELETE ' + localStorage.id);
                axios.delete('/section/destroy/' + localStorage.id)
                .then(
                    (response) => { console.log(response) },
                    (error) => { console.log(error) }
                );
                $('#tr' + localStorage.id).remove();
            }
        }
    }
});

const BtnDelete = Vue.component('btn-delete', {
    template: '<button type="button" class="btn btn-danger btn-sm btn-remove" @click="setId(section)" data-toggle="modal" data-target="#exampleModal">{{ __('Delete') }}</button>',
    props: ['section'],
    methods: {
        setId(section) {
            localStorage.id = section;
            console.log('click ' + section);
        }
    },
});

new Vue({
    el: '#app',
    data: {
        'id': 0
    },
    components: {
        BtnDelete,
        ConfirmDelete,
    },
    mounted() {
        if (localStorage.id) {
            this.id = localStorage.id;
        }
    },
    methods: {}
});
</script>
@endpush

<style>
.w40 {width: 30%}
</style>
