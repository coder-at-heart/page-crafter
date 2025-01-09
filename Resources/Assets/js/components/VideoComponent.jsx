import React, { useState } from 'react'
import Error from './Error'

const VideoComponent = ({ data, errors, onChange }) => {
  const [localData, setLocalData] = useState({
    provider: 'vimeo',
    code: '',
    autoplay: false,
    ...data,
  })

  const handleProviderChange = e => {
    const updatedData = { ...localData, provider: e.target.value }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  const handleCodeChange = e => {
    const updatedData = { ...localData, code: e.target.value }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  const handleAutoplayChange = e => {
    const updatedData = { ...localData, autoplay: e.target.value }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  const videoSrc = () => {
    if (!localData.code || !localData.provider) {
      return ''
    }

    if (localData.provider === 'vimeo') {
      return `https://player.vimeo.com/video/${localData.code}`
    }
    return `https://www.youtube.com/embed/${localData.code}`
  }

  return (
    <div className='d-flex'>
      <div className='flex-grow-1'>
        <div className='mb-2'>
          <label>Provider:</label>
          <select
            className='form-control'
            value={localData.provider}
            onChange={handleProviderChange}
          >
            <option value='youtube'>YouTube</option>
            <option value='vimeo'>Vimeo</option>
          </select>
        </div>
        <div className='mb-2'>
          <label>Video ID:</label>
          <input
            className='form-control'
            type='text'
            placeholder='253905163'
            value={localData.code}
            onChange={handleCodeChange}
          />
          <Error errors={errors?.code} />
        </div>
        <div className='d-flex align-items-right justify-content-end  mt-2 w-60'>
          <label>
            <input
              type='checkbox'
              checked={localData.autoplay}
              onChange={handleAutoplayChange}
              className='mr-2'
            />
            Autoplay
          </label>
        </div>
      </div>
      <div>
        {localData.code && videoSrc && (
          <div className='ml-2'>
            <iframe
              src={videoSrc()}
              height='150' // Fixed height
              style={{ width: '100%' }} // Auto-adjust width
              frameBorder='0'
              allow='autoplay; encrypted-media'
              allowFullScreen
              title='Embedded Video'
            ></iframe>
          </div>
        )}
      </div>
    </div>
  )
}

export default VideoComponent
