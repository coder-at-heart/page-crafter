import React, { useState } from 'react'
import TextComponent from './TextComponent'
import Error from './Error'

const AccordionComponent = ({ data, errors, onChange }) => {
  const [localData, setLocalData] = useState(
    data || { title: '', text: { body: '', markdown: '' }, open: false },
  )

  const handleTitleChange = e => {
    const updatedData = { ...localData, title: e.target.value }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  const handleTextChange = data => {
    const updatedData = { ...localData, text: data }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  const handleOpenChange = e => {
    const updatedData = { ...localData, open: e.target.value }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  return (
    <div>
      <div className='mb-2'>
        <label>Title</label>
        <input
          className='form-control d-inline-bloc'
          type='text'
          placeholder='Accordion Title'
          onChange={handleTitleChange}
          style={{ marginRight: '5px' }}
          value={localData.title}
        />
        <Error errors={errors?.title} />
      </div>
      <div className='mb-2'>
        <TextComponent
          data={localData.text}
          errors={errors?.text}
          onChange={handleTextChange}
        />
      </div>

      <div className='d-flex align-items-right justify-content-end mt-2'>
        <label>
          <input
            type='checkbox'
            checked={localData.open}
            onChange={handleOpenChange}
            style={{ marginRight: '5px' }}
          />
          Start Opened
        </label>
      </div>
    </div>
  )
}

export default AccordionComponent
