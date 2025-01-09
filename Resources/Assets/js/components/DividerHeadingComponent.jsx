import React, { useState } from 'react'
import Error from './Error'

const DividerHeadingComponent = ({ data, errors, onChange }) => {
  const [localData, setLocalData] = useState({
    line1: '',
    line2: '',
    ...data, // Merge provided data, overwriting defaults where necessary
  })
  const handleLine1Change = e => {
    const updatedData = { ...localData, line1: e.target.value }
    setLocalData(updatedData)
    onChange(updatedData)
  }
  const handleLine2Change = e => {
    const updatedData = { ...localData, line2: e.target.value }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  return (
    <div className='d-flex flex-column'>
      <div className='mb-2'>
        <label>Line 1:</label>
        <input
          className='form-control'
          type='text'
          placeholder='heading'
          value={localData.line1}
          onChange={handleLine1Change}
        />
        <Error errors={errors?.line1} />
      </div>

      <div className='mb-2'>
        <label>Line 2:</label>
        <input
          className='form-control'
          type='text'
          placeholder='heading'
          value={localData.line2}
          onChange={handleLine2Change}
        />
        <Error errors={errors?.line2} />
      </div>
    </div>
  )
}

export default DividerHeadingComponent
