import React, { useState } from 'react'

const ActivityComponent = ({ data, errors, config, onChange }) => {
  const [localData, setLocalData] = useState({
    type: 'next',
    id:
      Array.isArray(config.activities) && config.activities.length > 0
        ? config.activities[0].id
        : null,
    ...data,
  })
  const handleTypeChange = e => {
    const updatedData = { ...localData, type: e.target.value }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  const handleActivityChange = e => {
    const updatedData = { ...localData, id: e.target.value }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  return (
    <div className='d-flex flex-column'>
      <div className='mb-2'>
        <label>Type</label>
        <select
          className='form-control'
          value={localData.type}
          onChange={handleTypeChange}
        >
          {Object.entries(config.types).map(([key, value]) => (
            <option key={key} value={key}>
              {value}
            </option>
          ))}
        </select>
      </div>

      {localData.type === 'specific' && (
        <div className='mb-2'>
          <label>Activity</label>
          <select
            className='form-control'
            value={localData.id}
            onChange={handleActivityChange}
          >
            {Object.entries(config.activities).map(([key, value]) => (
              <option key={key} value={key}>
                {value}
              </option>
            ))}
          </select>
        </div>
      )}
    </div>
  )
}

export default ActivityComponent
