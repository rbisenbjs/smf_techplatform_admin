@extends('layouts.userBased'))
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-min.js"></script>
    <script src="https://surveyjs.azureedge.net/1.0.56/survey.ko.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ace.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>
    
    <link href="https://surveyjs.azureedge.net/1.0.56/surveyeditor.css" type="text/css" rel="stylesheet"/>
    <script src="https://surveyjs.azureedge.net/1.0.56/surveyeditor.js"></script>
    <!--link rel="stylesheet" href="https://unpkg.com/bootstrap@3.3.7/dist/css/bootstrap.min.css"-->
    <script src="https://surveyjs.azureedge.net/1.0.56/survey.jquery.min.js"></script>
    <select onmousewheel="return false;" class="form-control" data-bind="options: koLanguages, value: koActiveLanguage, optionsText:'text', optionsValue: 'value'" id="language"><option value="">Default (english)</option><option value="ar">العربية</option><option value="ca">català</option><option value="cz">čeština</option><option value="da">dansk</option><option value="de">deutsch</option><option value="en">english</option><option value="es">español</option><option value="fa">فارْسِى</option><option value="fi">suomalainen</option><option value="fr">français</option><option value="gr">ελληνικά</option><option value="he">עברית</option><option value="hu">magyar</option><option value="is">íslenska</option><option value="it">italiano</option><option value="ka">ქართული</option><option value="ko">한국어</option><option value="lv">latviešu</option><option value="nl">nederlands</option><option value="no">norsk</option><option value="pl">polski</option><option value="pt">português</option><option value="ro">română</option><option value="ru">русский</option><option value="sv">svenska</option><option value="tr">türkçe</option><option value="zh-cn">简体中文</option><option value="zh-tw">繁體中文</option></select>

                    <div id="surveyContainer">
                        <div id="editorElement"></div>
                    </div>
        </div>
    </div>
     <!-- Scripts -->
     <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script-->
<script src="{{ asset('js/take_survey.js') }}" jsonText="{{ $json }}" id="json_survey" userID="{{ Auth::user()->id }}" surveyID="{{ $survey_id }}"></script>
@endsection