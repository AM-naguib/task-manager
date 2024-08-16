import YooptaEditor, { createYooptaEditor } from '@yoopta/editor';

import Paragraph from '@yoopta/paragraph';
import Blockquote from '@yoopta/blockquote';
import Embed from '@yoopta/embed';
import Image from '@yoopta/image';
import Link from '@yoopta/link';
import Callout from '@yoopta/callout';
import Video from '@yoopta/video';
import File from '@yoopta/file';
import { NumberedList, BulletedList, TodoList } from '@yoopta/lists';
import { Bold, Italic, CodeMark, Underline, Strike, Highlight } from '@yoopta/marks';
import { HeadingOne, HeadingThree, HeadingTwo } from '@yoopta/headings';
import Code from '@yoopta/code';
import ActionMenuList, { DefaultActionMenuRender } from '@yoopta/action-menu-list';
import Toolbar, { DefaultToolbarRender } from '@yoopta/toolbar';
import LinkTool, { DefaultLinkToolRender } from '@yoopta/link-tool';

import { useEffect, useMemo, useRef } from 'react';
import { withSavingToDatabaseValue } from './initValue';

const plugins = [
  Paragraph,
  HeadingOne,
  HeadingTwo,
  HeadingThree,
  Blockquote,
  Callout,
  NumberedList,
  BulletedList,
  TodoList,
  Code,
  Link,
  Embed,
  Image,
  Video,
  File
];

const TOOLS = {
  ActionMenu: {
    render: DefaultActionMenuRender,
    tool: ActionMenuList,
  },
  Toolbar: {
    render: DefaultToolbarRender,
    tool: Toolbar,
  },
  LinkTool: {
    render: DefaultLinkToolRender,
    tool: LinkTool,
  },
};

const MARKS = [Bold, Italic, CodeMark, Underline, Strike, Highlight];

function WithSavingToDatabase() {
  const editor = useMemo(() => createYooptaEditor(), []);
  const selectionRef = useRef(null);

  const fetchToServer = async (data) => {
    //save the data in hidden input, data is json string
    document.getElementById('description').value = JSON.stringify(data);
  };

  const onSaveToServer = async () => {
    const editorContent = editor.getEditorValue();
    await fetchToServer(editorContent);
  };

  function handleChange(value) {
    console.log('DATA ON CHANGE', value);
  }

  useEffect(() => {
      editor.on('change', handleChange);
    return () => {
      editor.off('change', handleChange);
    };
  }, [editor]);

  return (
    <div
      ref={selectionRef}
    >
      <YooptaEditor
        editor={editor}
        plugins={plugins}
        tools={TOOLS}
        marks={MARKS}
        selectionBoxRoot={selectionRef}
        className='form-control'
        value={{}}
      />

        <button
              type="button"
              onClick={onSaveToServer}
              className="btn btn-primary mt-4"
        >
          Save data
      </button>

    </div>
  );
}

export default WithSavingToDatabase;