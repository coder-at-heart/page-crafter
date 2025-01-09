import React, { useState } from 'react'
import Error from './Error'

const PulloutTextComponent = ({ data, errors, onChange }) => {
  const [localData, setLocalData] = useState({
    text: '',
    ...data,
  })
  const handleTextChange = e => {
    const updatedData = { ...localData, text: e.target.value }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  return (
    <div className='d-flex flex-column'>
      <div className='mb-2'>
        <label>Text:</label>
        <textarea
          className='form-control'
          placeholder='text'
          value={localData.text}
          onChange={handleTextChange}
        />
        <Error errors={errors?.text} />
      </div>
    </div>
  )
}

export default PulloutTextComponent
