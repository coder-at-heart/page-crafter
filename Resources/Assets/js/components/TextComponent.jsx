import React, { useRef } from 'react'
import { EditorContent, useEditor } from '@tiptap/react'
import StarterKit from '@tiptap/starter-kit'
import { Markdown } from 'tiptap-markdown'
import Error from './Error'

const TextComponent = ({ data, errors, onChange }) => {
  const editor = useEditor({
    extensions: [StarterKit, Markdown],
    content: data?.html || '',
    onUpdate: ({ editor }) => {
      onChange({
        html: editor.getHTML(),
        markdown: editor.storage.markdown.getMarkdown(),
      })
    },
  })

  const applyStyle = (e, styleFunction) => {
    e.preventDefault()
    if (editor) {
      styleFunction()
      editor
        .chain()
        .focus()
        .run()
    }
  }

  return (
    <div className='pagecraft-component__text'>
      <div className='d-flex justify-content-start pb-2 gap-2'>
        <button
          className='btn btn-secondary mr-2'
          onMouseDown={e =>
            applyStyle(e, () =>
              editor
                .chain()
                .toggleHeading({ level: 1 })
                .run(),
            )
          }
        >
          H1
        </button>
        <button
          className='btn btn-secondary mr-2'
          onMouseDown={e =>
            applyStyle(e, () =>
              editor
                .chain()
                .toggleHeading({ level: 2 })
                .run(),
            )
          }
        >
          H2
        </button>
        <button
          className='btn btn-secondary mr-2'
          onMouseDown={e =>
            applyStyle(e, () =>
              editor
                .chain()
                .toggleBold()
                .run(),
            )
          }
        >
          <i className='fas fa-bold'></i>
        </button>
        <button
          className='btn btn-secondary mr-2'
          onMouseDown={e =>
            applyStyle(e, () =>
              editor
                .chain()
                .toggleItalic()
                .run(),
            )
          }
        >
          <i className='fas fa-italic'></i>
        </button>
        <button
          className='btn btn-secondary mr-2'
          onMouseDown={e => {
            e.preventDefault()
            const url = prompt('Enter the URL')
            if (url) {
              applyStyle(e, () =>
                editor
                  .chain()
                  .extendMarkRange('link')
                  .setLink({ href: url })
                  .run(),
              )
            }
          }}
        >
          <i className='fas fa-link'></i>
        </button>
        <button
          className='btn btn-secondary mr-2'
          onMouseDown={e =>
            applyStyle(e, () =>
              editor
                .chain()
                .toggleBulletList()
                .run(),
            )
          }
        >
          <i className='fas fa-list-ul'></i>
        </button>
        <button
          className='btn btn-secondary mr-2'
          onMouseDown={e =>
            applyStyle(e, () =>
              editor
                .chain()
                .toggleOrderedList()
                .run(),
            )
          }
        >
          <i className='fas fa-list-ol'></i>
        </button>
      </div>

      <EditorContent editor={editor} className='editor' />
      <Error errors={errors?.markdown} />
    </div>
  )
}

export default TextComponent
