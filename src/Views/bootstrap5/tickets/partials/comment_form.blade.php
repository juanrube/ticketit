{!! Html::form()->action(route($setting->grab('main_route').'-comment.store'))->method('POST')->open() !!}

{!! Html::hidden('ticket_id', $ticket->id) !!}

{!! Html::textarea('content')->class('form-control summernote-editor')->rows(3) !!}

{!! Html::submit(trans('ticketit::lang.reply'))->class('btn btn-outline-primary pull-right mt-3 mb-3') !!}

{!! Html::form()->close() !!}
