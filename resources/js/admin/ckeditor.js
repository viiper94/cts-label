import ClassicEditor from '@ckeditor/ckeditor5-editor-classic/src/classiceditor';
import Essentials from '@ckeditor/ckeditor5-essentials/src/essentials';
import Paragraph from '@ckeditor/ckeditor5-paragraph/src/paragraph';
import Bold from '@ckeditor/ckeditor5-basic-styles/src/bold';
import Italic from '@ckeditor/ckeditor5-basic-styles/src/italic';
import SourceEditing from "@ckeditor/ckeditor5-source-editing/src/sourceediting";
import List from '@ckeditor/ckeditor5-list/src/list';
import Link from '@ckeditor/ckeditor5-link/src/link';
import AutoLink from '@ckeditor/ckeditor5-link/src/autolink';

import '../../sass/admin/_ckeditor.css'

// Editor configuration.
ClassicEditor.defaultConfig = {
    plugins: [Essentials, Paragraph, Bold, Italic, Link, AutoLink, SourceEditing, List],
    toolbar:  ['sourceEditing', '|', 'bold', 'italic', 'link', '|', 'numberedList', 'bulletedList', '|', 'undo', 'redo'],
    // This value must be kept in sync with the language defined in webpack.config.js.
    language: 'ru'
};

window.ClassicEditor = ClassicEditor;
