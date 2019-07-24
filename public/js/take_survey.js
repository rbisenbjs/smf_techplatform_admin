$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


// var a = window.location.href;

  // var url = new URL(a);

  // var b = '/' + url.pathname.substr(url.pathname.indexOf('/',4) + 1);

  // SurveyEditor
  //     .StylesManager
  //     .applyTheme("bootstrap");
  
  // var editorOptions = {};
  // var editor = new SurveyEditor.SurveyEditor("editorElement", editorOptions);

  

  Survey.Survey.cssType = "bootstrap";
  
  var json = $('#json_survey').attr('jsonText');
  var u_id = $('#json_survey').attr('userID');
  var s_id = $('#json_survey').attr('surveyID');


  function sendDataToServer(survey) {
    //send Ajax request to your web server.
    var survey_result = JSON.stringify(survey.data);
    console.log('sending data to the server');
    var orgId=window.location.pathname.split('/')[1];
    var surveyId=window.location.pathname.split('/')[2];
    jQuery.ajax({
      type: "GET",
     
      url: "/"+orgId+"/"+surveyId+"/sendResponse",
      data: { jsonString:JSON.stringify(survey.data), userId:u_id, surveyId:s_id }
      });
  
  }

var survey = new Survey.Model(json);

$("#surveyContainer").Survey({
    model: survey,
    onComplete: sendDataToServer
});

$('#language').on('change', '', function (e) {
console.log(this.value)
survey.locale = this.value;
survey.render();
});