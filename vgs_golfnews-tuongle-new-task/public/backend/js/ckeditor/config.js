/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
    config.toolbarGroups = [
        {name: 'document', groups: ['mode', 'document', 'doctools']},
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
        {name: 'forms', groups: ['forms']},
        {name: 'styles', groups: ['styles']},
        {name: 'colors', groups: ['colors']},
        {name: 'tools', groups: ['tools']},
        {name: 'others', groups: ['others']},
        {name: 'about', groups: ['about']},
        '/',
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
        {name: 'links', groups: ['links']},
        {name: 'insert', groups: ['insert']}
    ];

    config.removeButtons = 'Save,NewPage,ExportPdf,Print,Templates,About,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Language,Iframe';

    config.extraPlugins = 'embed,embedbase,image2';

    config.height = 500;
    // config.autoGrow_minHeight = 500;
    // config.autoGrow_onStartup = true;

    config.embed_provider = '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}';
};
