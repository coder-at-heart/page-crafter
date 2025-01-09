import React, { useEffect, useState } from 'react'
import MediaHandler from './MediaHandler'
import Error from './Error'

const ImageComponent = ({ data, errors, onChange }) => {
  const [localData, setLocalData] = useState({ media_id: null, caption: '' })

  useEffect(() => {
    setLocalData(data)
  }, [data])

  const handleCaptionChange = e => {
    const updatedData = { ...localData, caption: e.target.value }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  const handleMediaIdChange = id => {
    const updatedData = { ...localData, media_id: id }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  return (
    <div className='mt-2'>
      <MediaHandler
        mediaId={localData.media_id}
        onChange={handleMediaIdChange}
      />
      <div className='mt-2'>
        <label>Caption</label>
        <input
          className='form-control'
          type='text'
          placeholder='Caption'
          value={localData.caption || ''}
          onChange={handleCaptionChange}
        />
        <Error errors={errors.caption} />
      </div>
    </div>
  )
}

export default ImageComponent
