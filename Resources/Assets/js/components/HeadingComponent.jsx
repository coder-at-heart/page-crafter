import React, { useState } from 'react'
import Error from './Error'

const HeadingComponent = ({ data, errors, onChange }) => {
  const [localData, setLocalData] = useState(data || { level: '1', text: '' })

  const handleLevelChange = e => {
    const updatedData = { ...localData, level: e.target.value }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  const handleTextChange = e => {
    const updatedData = { ...localData, text: e.target.value }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  return (
    <div className='d-flex'>
      <div className='mr-2'>
        <label>Level</label>
        <select
          className='form-control'
          value={localData.level}
          onChange={handleLevelChange}
        >
          <option value='1'>H1</option>
          <option value='2'>H2</option>
          <option value='3'>H3</option>
        </select>
      </div>
      <div className='flex-grow-1'>
        <label>Heading</label>
        <input
          className='form-control'
          type='text'
          placeholder='Heading Text'
          required
          value={localData.text}
          onChange={handleTextChange}
        />
        <Error errors={errors?.text} />
      </div>
    </div>
  )
}

export default HeadingComponent
