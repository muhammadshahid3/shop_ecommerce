function allowSummernoteBtns() {

  $('#add-summernote-btn').css({"display":"none"});
  $('#remove-summernote-btn').css({"display":"block"});
  // header contact
  $('#summernote_cms_texts_contact').css({'display':'inline-block','margin-right':'5px'});
  $('#summernote_cms_texts_contact').after('<button type="button" class="btn btn-outline-danger btn-sm summernote-edit-btn" id="edit_cms_texts-contact" onclick="summernoteGeneralSettingContact()"><i class="fa fa-pencil"></i></button>');
  // header logo
  $('#summernote_cms_texts_logo').css({'display':'inline-block','margin-right':'5px'});
  $('#summernote_cms_texts_logo').after('<button type="button" class="btn btn-outline-danger btn-sm summernote-edit-btn" id="edit_cms_texts_logo" onclick="summernoteGeneralSettingLogo()"><i class="fa fa-pencil"></i></button>');
  // Banner Button
  // $('#summernote_cms_texts_btn').css({'display':'inline-block','margin-right':'5px'});
  $('#summernote_shop_btn').after('<button type="button" class="btn btn-outline-danger btn-sm summernote-edit-btn"><i class="fa fa-pencil"></i></button>');
 
} 

function attachBtn(pass_value) {
  return function(context) {
    var ui = $.summernote.ui;
    var button = ui.button({
        contents: '<i class="fa fa-save text-primary"></i>',
        tooltip: "Save Content",
        click: function() {
          saveSummernote(pass_value);
        }
    });
    return button.render();
  }
};

async function saveSummernote(pass_value) {

  var tag_name = '';
  var tag_value = '';
  var token = $("meta[name = 'csrf-token']").attr('content');
// Header Contact
  if(pass_value === 'header_contact'){
    tag_name  = $("#header_contact_id").attr('value');
    tag_value  = $(".note-editable").text();
// Header logo
  }else if(pass_value === 'header_logo'){
    var tag_name = $("#header_logo_id").attr('value');
    var tag_value   = document.getElementById("logo_path").value;

  }
    
   await $.ajax({
      url : edit_content_url,
      method : 'POST',
      dataType : 'json',
      data: {'tag_name' : tag_name  ,'tag_value' : tag_value , '_token' : token},
      success  :function(response){
        window.location.href = website_url;
      },
      error: function (err){
        console.log(err);
      },
    }); 

  removeSummernote(pass_value);
}

function removeSummernote(pass_value) {
  if (pass_value == 'header_contact') {
    $('#summernote_cms_texts_contact').summernote('destroy');
  }

  if (pass_value == 'header_logo') {
    $('#summernote_cms_texts_logo').summernote('destroy');
  }

  $("#edit_cms_texts_contact").remove();
  $("#edit_cms_texts-logo").remove();

  $('#add-summernote-btn').css({"display":"block"});
  $('#remove-summernote-btn').css({"display":"none"});
}

function summernoteGeneralSettingContact() {
  $('#edit_cms_texts_contact').hide();
  $('#summernote_cms_texts_contact').summernote({
    tabsize: 2,
    height: 50,
    toolbar: [
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['strikethrough']],
      ['mybutton', ['customBtn']]
    ],
    buttons: {
    
      customBtn: attachBtn('header_contact')
    },
  });
}

function summernoteGeneralSettingLogo() {
  $('#edit_cms_texts_logo').hide();
  $('#summernote_cms_texts_logo').summernote({
    dialogsInBody: true,
    lang: 'fr-FR',
    tabsize: 2,
    height: 50,
    toolbar: [
         ['link',['link']],
        ['picture',['picture']],
      ['save-button', ['save']]
  
    ],
    popover: {
      image: [
        ['image', ['resizeFull', 'resizeHalf', 'resizeNone']],
        ['remove', ['removeMedia']]
      ],
    },

    buttons: {
      save: function () {
        return $('<i class="fa fa-save border p-2" style="cursor:pointer;"></i>')
            .click(function () {
              saveSummernote("header_logo");
            });
      }
    },
    callbacks : {
      onImageUpload: function(image) {
          uploadImage(image[0]);
      },

      onMediaDelete : function() {
        document.getElementById("logo_path").setAttribute('value','');
      },
    },
        
  });
}



function uploadImage(file){
  const reader = new FileReader();
  reader.onload = function (e) {
    document.getElementById("logo_path").setAttribute('value',e.target.result);
  };
  reader.readAsDataURL(file);
}


