@extends('layouts.app')
@section('content')
    {!! breadcrumb($breadcrumb) !!}
    <div class="html ui top attached segment">
        {{--<div class="ui grid">--}}
            {{--<div class="twelve wide stretched column">--}}
                {{--<h4 class="ui dividing header">{{ title_case(str_replace('_', ' ', snake_case($policy->name)) . ' module permissions') }}</h4>--}}

                {{--<div class="ui form">--}}
                    {{--<div class="fields">--}}
                        {{--@foreach($policyMethods as $policyMethod)--}}
                            {{--<div class="field">--}}
                                {{--<div class="ui checkbox">--}}
                                    {{--<input type="checkbox" value="{{ $policyMethod->id }}" tabindex="0" class="hidden policy-method-auth" {{ $policyMethod->authorized ? 'checked' : '' }}>--}}
                                    {{--<label>{{ studly_case($policyMethod->name) }}</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="four wide column">--}}
                {{--<div class="ui vertical fluid right tabular menu">--}}
                    {{--@foreach($policies as $policyObj)--}}
                        {{--<a class="item {{ $policy->id == $policyObj->id ? 'active' : '' }}" href="{{ route('role.show', ['role' => $role->id, 'policy' => $policyObj->id]) }}">{{ $policyObj->name }}</a>--}}
                    {{--@endforeach--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th style="width: 30%">Models</th>
                    <th colspan="9" style="text-align: center;">Action</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Menu</th>
                    <th>Create</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Import</th>
                </tr>

                </thead>
                <tbody>
                @foreach($policies as $policy)
                    <tr>
                        <td>{{ $policy->name }}</td>

                        @if($policyMethod = $policy->policyMethods->where('name', 'index')->first())
                            <td>
                                <input type="checkbox" value="{{ $policyMethod->id }}" id="index" name="index" class="minimal auth-policy-method" {{ $role->policyMethods->where('policy_id', $policy->id)->where('name', $policyMethod->name)->first() && $role->policyMethods->where('policy_id', $policy->id)->where('name', $policyMethod->name)->first()->pivot->authorized ? 'checked' : '' }}/>
                            </td>
                        @else
                            <td></td>
                        @endif
                        @if($policyMethod = $policy->policyMethods->where('name', 'create')->first())
                            <td>
                                <input type="checkbox" value="{{ $policyMethod->id }}" id="index" name="index" class="minimal auth-policy-method" {{ $role->policyMethods->where('policy_id', $policy->id)->where('name', $policyMethod->name)->first() && $role->policyMethods->where('policy_id', $policy->id)->where('name', $policyMethod->name)->first()->pivot->authorized ? 'checked' : '' }}/>
                            </td>
                        @else
                            <td></td>
                        @endif
                        @if($policyMethod = $policy->policyMethods->where('name', 'show')->first())
                            <td>
                                <input type="checkbox" value="{{ $policyMethod->id }}" id="index" name="index" class="minimal auth-policy-method" {{ $role->policyMethods->where('policy_id', $policy->id)->where('name', $policyMethod->name)->first() && $role->policyMethods->where('policy_id', $policy->id)->where('name', $policyMethod->name)->first()->pivot->authorized ? 'checked' : '' }}/>
                            </td>
                        @else
                            <td></td>
                        @endif
                        @if($policyMethod = $policy->policyMethods->where('name', 'edit')->first())
                            <td>
                                <input type="checkbox" value="{{ $policyMethod->id }}" id="index" name="index" class="minimal auth-policy-method" {{ $role->policyMethods->where('policy_id', $policy->id)->where('name', $policyMethod->name)->first() && $role->policyMethods->where('policy_id', $policy->id)->where('name', $policyMethod->name)->first()->pivot->authorized ? 'checked' : '' }}/>
                            </td>
                        @else
                            <td></td>
                        @endif
                        @if($policyMethod = $policy->policyMethods->where('name', 'delete')->first())
                            <td>
                                <input type="checkbox" value="{{ $policyMethod->id }}" id="index" name="index" class="minimal auth-policy-method" {{ $role->policyMethods->where('policy_id', $policy->id)->where('name', $policyMethod->name)->first() && $role->policyMethods->where('policy_id', $policy->id)->where('name', $policyMethod->name)->first()->pivot->authorized ? 'checked' : '' }}/>
                            </td>
                        @else
                            <td></td>
                        @endif
                        @if($policyMethod = $policy->policyMethods->where('name', 'import')->first())
                            <td>
                                <input type="checkbox" value="{{ $policyMethod->id }}" id="index" name="index" class="minimal auth-policy-method" {{ $role->policyMethods->where('policy_id', $policy->id)->where('name', $policyMethod->name)->first() && $role->policyMethods->where('policy_id', $policy->id)->where('name', $policyMethod->name)->first()->pivot->authorized ? 'checked' : '' }}/>
                            </td>
                        @else
                            <td></td>
                        @endif

                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var errorCallBack = false;
            
            $('input.policy-method-auth').parent('.ui.checkbox').checkbox({
                onChecked: function () {
                    if(errorCallBack) {
                        errorCallBack = false;
                        return;
                    }
                    updatePolicyMethod($(this), 1);
                },
                onUnchecked: function () {
                    if(errorCallBack) {
                        errorCallBack = false;
                        return;
                    }
                    updatePolicyMethod($(this), 0);
                }
            });

            function updatePolicyMethod(method, authorized) {
                var data = {};
                data._token = '{{ csrf_token() }}';
                data.method = method.val();
                data.authorized = authorized;
                $.ajax({
                    url : '{{ route('role.update.method', ['role' => $role->id, 'policy' => $policy->id]) }}',
                    method : 'PATCH',
                    data:data,
                    success: function () {
                        showSuccess();
                    },
                    error: function () {
                        errorCallBack = true;
                        method.parent('.ui.checkbox').checkbox('toggle');
                        sweetAlert('This action is unauthorized.', '', 'error');
                        console.clear();
                    }
                });
            }

            function showSuccess() {
                toastr.options = {
                    "positionClass": "toast-bottom-right"
                };
                toastr.success('Permission updated!')
            }
        });
    </script>
@endsection