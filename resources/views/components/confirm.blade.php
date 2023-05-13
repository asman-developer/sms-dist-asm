<div wire:ignore.self class="modal fade {{ $modalId }}" tabindex="-1" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <div class="mt-4">
                    <h4 class="mb-3">{{__('are_you_sure')}}</h4>
                    <div class="hstack gap-2 justify-content-center">
                        <form action="{{$route}}" method="POST">
                            @csrf
                            @method($method)
                            <button class="btn btn-success">
                                {{__('yes')}}
                            </button>
                        </form>
                        <a href="javascript:void(0);"
                           class="btn btn-link shadow-none link-success fw-medium" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1 align-middle"></i>
                            {{__('no')}}
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
