<div class="modal fade" id="ticket-edit-modal" tabindex="-1" role="dialog" aria-labelledby="ticket-edit-modal-Label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Html::form()->action(route($setting->grab('main_route') . '.update', $ticket->id))->method('PATCH')->class('form-horizontal')->open() !!}
            <div class="modal-header">
                <h5 class="modal-title" id="ticket-edit-modal-Label">{{ $ticket->subject }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">{{ trans('ticketit::lang.flash-x') }}</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    {!! Html::text('subject', $ticket->subject)->class('form-control')->required() !!}
                </div>
                <div class="form-group">
                    <textarea class="form-control summernote-editor" rows="5" required name="content" cols="50">{!! htmlspecialchars($ticket->html) !!}</textarea>
                </div>

                <div class="form-group">
                    {!! Html::label('priority_id', trans('ticketit::lang.priority') . trans('ticketit::lang.colon')) !!}
                    {!! Html::select('priority_id', $priority_lists, $ticket->priority_id)->class('form-control') !!}
                </div>

                <div class="form-group">
                    {!! Html::label('agent_id', trans('ticketit::lang.agent') . trans('ticketit::lang.colon')) !!}
                    {!! Html::select('agent_id', $agent_lists, $ticket->agent_id)->class('form-control') !!}
                </div>

                <div class="form-group">
                    {!! Html::label('category_id', trans('ticketit::lang.category') . trans('ticketit::lang.colon')) !!}
                    {!! Html::select('category_id', $category_lists, $ticket->category_id)->class('form-control') !!}
                </div>

                <div class="form-group">
                    {!! Html::label('status_id', trans('ticketit::lang.status') . trans('ticketit::lang.colon')) !!}
                    {!! Html::select('status_id', $status_lists, $ticket->status_id)->class('form-control') !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('ticketit::lang.btn-close') }}</button>
                {!! Html::submit(trans('ticketit::lang.btn-submit'))->class('btn btn-primary') !!}
            </div>
            {!! Html::form()->close() !!}
        </div>
    </div>
</div>