import React, { useEffect, useState } from 'react'
import axios from 'axios'
import FileUpload from '../../../../../../../resources/js/form/FileUpload/FileUpload'

const MediaHandler = ({ mediaId, onChange }) => {
  const [previewUrl, setPreviewUrl] = useState(null)

  // Fetch existing image if mediaId is provided
  useEffect(() => {
    if (mediaId) {
      setPreviewUrl(`/admin/pagecraft/media/${mediaId}`)
    }
  }, [mediaId])
  const handleRemoveImage = () => {
    setPreviewUrl(null)
    onChange(null) // Set mediaId to null
  }

  const handleImageChange = async image => {
    if (!image || !image.key || !image.filename) {
      console.error(
        "The image object must have both 'key' and 'filename' properties.",
      )
      return
    }

    try {
      const response = await axios.post('/admin/pagecraft/media/upload', image)

      const { id, url } = response.data
      setPreviewUrl(url)
      if (onChange) {
        onChange(id) // Pass the new media ID to the parent component
      }
    } catch (error) {
      console.error('Error uploading image:', error)
    }
  }

  return (
    <div>
      {previewUrl ? (
        <div className='mt-3 d-flex align-items-center'>
          <img
            src={previewUrl}
            alt='Uploaded Preview'
            style={{ maxHeight: '100px', maxWidth: 'auto' }}
          />
          <button
            onClick={handleRemoveImage}
            className='ml-2 btn btn-sm btn-secondary'
          >
            <i className='fa fa-trash'></i>
          </button>
        </div>
      ) : (
        <div>
          <FileUpload
            name='media'
            onSuccess={media => handleImageChange(media)}
          />
        </div>
      )}
    </div>
  )
}

export default MediaHandler
