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

import { useEffect, useMemo, useRef, useState } from 'react';

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
  File,
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

function AddTask({ taskId }) {
  const editor = useMemo(() => createYooptaEditor(), []);
  const selectionRef = useRef(null);
  const [loading, setLoading] = useState(true);
  const [initialValue, setInitialValue] = useState({});
  const [editorKey, setEditorKey] = useState(Date.now()); // Key for forced re-render

  const fetchToServer = async (data) => {
    document.getElementById('description').value = JSON.stringify(data);
  };

  const onSaveToServer = async () => {
    const editorContent = editor.getEditorValue();
    await fetchToServer(editorContent);
    console.log('Saved task with ID:', taskId);
  };

  const deleteContent = () => {
    setInitialValue({}); // Clear the state
    editor.setEditorValue({}); // Clear the editor content
    setEditorKey(Date.now()); // Force re-render by changing the key
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

  useEffect(() => {
    const fetchTaskData = async () => {
      if (taskId) {
        try {
          const response = await fetch(`/tasks/${taskId}`);
          if (response.ok) {
            const taskData = await response.json();
            let description = taskData.task.description;
            if (typeof description === 'string') {
              try {
                description = JSON.parse(description);
              } catch (parseError) {
                console.error('Error parsing description JSON:', parseError);
                description = {};
              }
            }
    
            if (typeof description === 'object' && description !== null) {
              setInitialValue(description);
              editor.setEditorValue(description);
            } else {
              console.error('Invalid description format');
            }
          } else {
            console.error('Failed to fetch task data');
          }
        } catch (error) {
          console.error('Error fetching task data:', error);
        } finally {
          setLoading(false);
        }
      } else {
        setLoading(false);
      }
    };    

    fetchTaskData();
  }, [taskId]);

  if (loading) {
    return <div>Loading...</div>;
  }

  return (
    <div ref={selectionRef}>
      <YooptaEditor
        key={editorKey} // Use key to force re-render
        editor={editor}
        plugins={plugins}
        tools={TOOLS}
        marks={MARKS}
        selectionBoxRoot={selectionRef}
        value={initialValue}
      />

      <button type="button" onClick={onSaveToServer} className="btn btn-primary mt-4">
        Save data
      </button>
    </div>
  );
}

export default AddTask;