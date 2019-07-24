 $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    Survey.surveyLocalization.locales["mr"] = Survey.surveyLocalization.locales["en-us"];
                  Survey.surveyLocalization.localeNames["mr"] = "Marathi"; 
                  Survey.surveyLocalization.locales["hi"] = Survey.surveyLocalization.locales["en-us"];
                  Survey.surveyLocalization.localeNames["hi"] = "Hindi";
                  Survey.surveyLocalization.supportedLocales = ["en", "mr","hi"];
  
          SurveyEditor
          .StylesManager
          .applyTheme("bootstrap");


          var editorOptions = {
            showJSONEditorTab: false,
            showTestSurveyTab:false,
            showTranslationTab:true,
            showEmbededSurveyTab:false,
            showPagesToolbox:false,
            questionTypes : ["boolean","text", "checkbox", "radiogroup", "dropdown","file","panel","imagepicker","matrixdynamic","comment"]
        }; 
        Survey.JsonObject.metaData.findProperty("Survey", "checkErrorsMode").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "clearInvisibleValues").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "completeText").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "completedBeforeHtml").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "completedHtml").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "cookieName").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "firstPageIsStarted").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "focusFirstQuestionAutomatic").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "goNextPageAutomatic").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "isSinglePage").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "loadingHtml").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "maxOthersLength").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "maxTextLength").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "maxTimeToFinish").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "maxTimeToFinishPage").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "pageNextText").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "pagePrevText").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "questionErrorLocation").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "questionStartIndex").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "questionTitleLocation").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "questionTitleTemplate").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "questionsOrder").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "sendResultOnPageNext").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "showCompletedPage").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "showNavigationButtons").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "showPageNumbers").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "showPageTitles").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "showPrevButton").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "showProgressBar").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "showQuestionNumbers").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "showTimerPanel").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "showTimerPanelMode").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "showTitle").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "startSurveyText").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "storeOthersAsComment").visible = false;
        Survey.JsonObject.metaData.findProperty("Survey", "triggers").visible = false;

        Survey.JsonObject.metaData.findProperty("question", "correctAnswer").visible = false;
//        Survey.JsonObject.metaData.findProperty("question", "defaultValue").visible = false;
        Survey.JsonObject.metaData.findProperty("question", "indent").visible = false;
        //Survey.JsonObject.metaData.findProperty("question", "placeHolder").visible = false;
        Survey.JsonObject.metaData.findProperty("question", "startWithNewLine").visible = false;
        Survey.JsonObject.metaData.findProperty("question", "titleLocation").visible = false;
        Survey.JsonObject.metaData.findProperty("question", "useDisplayValuesInTitle").visible = false;
        Survey.JsonObject.metaData.findProperty("question", "width").visible = false;

        var editor = new SurveyEditor.SurveyEditor("editorElement", editorOptions);

          var projectId = $('#pid').attr('value');
          var categoryId = $('#cat_id').attr('value');
        
          editor.text = $('#id').attr('value');
          var surveyID = $('#id').attr('surveyID');
        
          var x = document.getElementsByClassName('svd_commercial_container')[0];
            x.style.display = "none";

            $('.navbar-default .nav-item a').first().html('Form Designer');
            $('#svd-survey-settings').find('span').html('Form Settings');
            $('#svd-save').find('span').html('Save Form');
            $('#objectSelector').find('option').html('Form');
        
          //document.getElementsByClassName('nav-link')[1].innerText = 'Form Designer';
        
          // var buttonElements = document.getElementsByTagName('button');
          //   buttonElements[4].innerHTML= '<span data-bind="text: title">Form Settings</span>';
          //   buttonElements[5].innerHTML= '<span data-bind="text: title">Save Form</span>';
        
          // document.getElementById('objectSelector')[0].innerHTML = 'Form';
        
          var orgId=window.location.pathname.split('/')[1];
        
          editor.saveSurveyFunc = function () {
             
              var jsonEl = document.getElementById('surveyContainer');
              jsonEl.value = editor.text;
              var orgId=window.location.pathname.split('/')[1];
        
              active = $('#active').is(":checked");
              
              editable = $('#editable').is(":checked");
              //$('#editable').prop('checked')
              //alert('check this val'+editable);
              //console.log('check this val'+editable);
              multiple_entry = $('#multiple_entry').is(":checked");
              var deletable = $('#deletable').is(":checked");
              var assigned_roles = $('#assigned_roles').val();
        
              var projectId = $('#pid').val();
              var categoryId = $('#cat_id').val();  
              var microserviceId = $('#service_id').val();
        
              var entityId = $('#entity_id').val();    
        
            jQuery.ajax({
                type: "POST",
                url: "/saveEditedform",
                data: { json:jsonEl.value, 
                        // creator_id:creatorId,
                        surveyID:surveyID,
                        orgId:orgId,
                        active:active,
                        editable:editable,
                        deletable:deletable,
                        multiple_entry:multiple_entry,
                        assigned_roles:assigned_roles,
        				category_id:categoryId,
                        project_id:projectId,
                        microservice_id:microserviceId,
                        entity_id:entityId
        				},
                success:function(res){
                    window.location.href = "/"+orgId+"/editKeys/"+res.substr(1,res.length-2);
                    // +"?redirectTo="+$('#previousURL').val();
                }
              });           
        
            }