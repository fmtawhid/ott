<div class="row">
  <div class="col-md-4">
      <div class="row">
          {{ html()->hidden('id',null) }}
          <div class="col-md-12">
              <div class="form-group">
                  <label class="form-label">{{ (__('notification.lbl_type')) }} <span class="text-danger">*</span></label>
                  <select name="type" class="form-control select2" id="type" onchange="onChangeType()" data-ajax--url="{{ route('backend.notificationtemplates.ajax-list',['type' => 'constants_key','data_type' => 'notification_type']) }}" data-ajax--cache="true" required>
                      @if(isset($data->type))
                        <option value="{{ $data->type }}" selected>{{ $data->constant->name ?? '' }}</option>
                      @endif
                  </select>
                  <div class="invalid-feedback" id="name-error">Type field is required</div>
              </div>
          </div>
          <div class="col-md-12">
              <div class="form-group">
                  <label class="form-label">{{ (__('notification.parameters')) }} :</label>
                    <div class="main_form">
                        @if(isset($buttonTypes))
                            @include('notificationtemplate::backend.notificationtemplates.perameters-buttons',['buttonTypes' => $buttonTypes])
                        @endif
                  </div>                  
              </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
            <label class="form-label" for="category-status">{{ __('messages.lbl_status') }} :</label>
            <div class="d-flex justify-content-between align-items-center form-control">
              <label class="form-label mb-0 text-body" for="category-status">{{ __('messages.active') }} :</label>
              <div class="form-check form-switch">
                <input class="form-check-input" value="1" name="status" id="category-status" type="checkbox" {{ isset($data) && old('status', $data->status) == 1 ? 'checked' : '' }} />
              </div>
            </div>
          </div>
        </div>
          <div class="col-md-12">
              <div class="form-group">
                  <label class="form-label">{{ (__('notification.lbl_to')) }} :</label><br>
                  <select name="to[]" class="form-control select2" data-ajax--url="{{ route('backend.notificationtemplates.ajax-list',['type' => 'constants_key','data_type' => 'notification_to']) }}" data-ajax--cache="true" multiple>
                      @if(isset($data))
                      @if($data->to != null)
                      @foreach(json_decode($data->to) as $to)
                      <option value="{{$to}}" selected="">{{$to}}</option>
                      @endforeach
                      @endif
                      @endif
                  </select>
              </div>
          </div>
          <div class="col-md-12">
              <div class="form-group">
                  <label class="form-label">{{ (__('notification.lbl_bcc')) }} :</label><br>
                  <select class="form-control select2-tag" name="bcc[]" multiple="">
                      @if(isset($data))
                      @if($data->bcc != null)
                      @foreach(json_decode($data->bcc) as $bcc)
                      <option value="{{$bcc}}" selected="">{{$bcc}}</option>
                      @endforeach
                      @endif
                      @endif
                  </select>
              </div>
          </div>
          <div class="col-md-12">
              <div class="form-group">
                  <label class="form-label">{{ (__('notification.lbl_cc')) }} :</label><br>
                  <select class="form-control select2-tag" name="cc[]" multiple="">
                      @if(isset($data))
                      @if($data->cc != null)
                      @foreach(json_decode($data->cc) as $cc)
                      <option value="{{$cc}}" selected="">{{$cc}}</option>
                      @endforeach
                      @endif
                      @endif
                  </select>
              </div>
          </div>
      </div>
  </div>
  <div class="col-md-8 ">
      <div class="row pl-3">
          <div class="col-md-12">
              <div class="form-group">
                  <label class="float-left form-label">{{ (__('messages.subject')) }} <span class="text-danger">*</span></label>
                  {{ html()->text("defaultNotificationTemplateMap[subject]",null,)
                   ->class('form-control')
                   ->value($data->defaultNotificationTemplateMap->subject ?? '')
                   ->required() }}
                  {{ html()->hidden("defaultNotificationTemplateMap[status]",1)
                    ->class('form-control') }}
                    <div class="invalid-feedback" id="name-error">Subject field is required</div>
              </div>

              <div class="text-left">
                  <label class="form-label">{{ (__('messages.template')) }} :</label>
                  {{ html()->hidden("defaultNotificationTemplateMap[language]",'en') }}
              </div>
              <div class="form-group">
                  {{ html()->textarea("defaultNotificationTemplateMap[template_detail]",null)
                   ->class('form-control textarea')
                   ->attribute('id', "mytextarea")
                   ->value($data->defaultNotificationTemplateMap->template_detail ?? '') }}
              </div>
              <div class="form-group">
                  <label class="float-left form-label">{{ (__('messages.notification_body')) }} :</label>
                  {{ html()->text("defaultNotificationTemplateMap[notification_message]",null)
                  ->class('form-control notification_message')
                  ->attribute('id', "en-notification_message")
                  ->value($data->defaultNotificationTemplateMap->notification_message ?? '') }}

              </div>
              <div class="form-group">
                  <label class="float-left form-label">{{ (__('messages.notification_link')) }} :</label>
                  {{ html()->text("defaultNotificationTemplateMap[notification_link]",null)
                  ->class('form-control notification_link')
                  ->attribute('id', "en-notification_link")
                  ->value($data->defaultNotificationTemplateMap->notification_link ?? '') }}

              </div>
          </div>
      </div>
  </div>
  <div class="row">
      <div class="col-md-12 pt-2">
          <button type="submit" class="btn btn-primary"> {{ (__('messages.save'))}}<i class="md md-lock-open"></i></button>
      </div>
  </div>
</div>
<script>
  function onChangeType(url, render) {
      var dropdown = document.getElementById("type");
      var selectedValue = dropdown.value;
      var url = "{{ route('backend.notificationtemplates.notification-buttons',['type' => 'buttonTypes']) }}";
      $.get(url, function(data) {
          var html = data;
          if (render !== undefined && render !== '' && render !== null) {
              $('.' + render).html(html);
          } else {
              $(".main_form").html(html);
              $("#formModal").modal("show");
          }
      });
  }
</script>
