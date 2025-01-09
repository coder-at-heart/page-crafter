import React, { useState } from 'react'
import MediaHandler from './MediaHandler'
import Error from './Error'

const OnboardingComponent = ({ data, errors, onChange }) => {
  const [slides, setSlides] = useState(
    data.slides || [
      { title: '', media_id: null, body: '' },
      { title: '', media_id: null, body: '' },
      { title: '', media_id: null, body: '' },
      { title: '', media_id: null, body: '' },
    ],
  )

  const updateSlide = (index, field, value) => {
    const updatedSlides = slides.map((slide, i) =>
      i === index ? { ...slide, [field]: value } : slide,
    )
    setSlides(updatedSlides)
    onChange({ slides: updatedSlides })
  }

  const handleMediaIdChange = (index, mediaId) => {
    const updatedSlides = slides.map((slide, i) =>
      i === index ? { ...slide, media_id: mediaId } : slide,
    )
    console.log(updatedSlides)
    setSlides(updatedSlides)
    onChange({ slides: updatedSlides })
  }

  const getErrorForIndex = (index, field) => {
    if (
      typeof errors.slides === 'object' && // Ensure slides is an object
      errors.slides[index] && // Ensure index exists in slides
      typeof errors.slides[index][field] !== 'undefined' // Ensure field exists
    ) {
      return errors.slides[index][field]
    }

    return {}
  }

  return (
    <div>
      {slides.map((slide, index) => (
        <div key={index}>
          <h6 className='mb-2'>Slide {index + 1} </h6>
          <div className='slide mb-2 rounded-lg p-2 bg-white border-light-grey border'>
            <div className='d-flex justify-content-between align-items-center'>
              <div>
                <label>Heading:</label>
                <input
                  className='form-control d-inline-block mb-2'
                  type='text'
                  placeholder='Slide Name'
                  value={slide.title}
                  minLength={5}
                  onChange={e => updateSlide(index, 'title', e.target.value)}
                />
                <Error errors={getErrorForIndex(index, 'title')} />

                <label>Body:</label>
                <textarea
                  className='form-control d-inline-block'
                  placeholder='Slide Body Content'
                  value={slide.body}
                  onChange={e => updateSlide(index, 'body', e.target.value)}
                />
                <Error errors={getErrorForIndex(index, 'body')} />
              </div>

              <div>
                <MediaHandler
                  mediaId={slide.media_id}
                  onChange={mediaId => handleMediaIdChange(index, mediaId)}
                />
                <Error errors={getErrorForIndex(index, 'media_id')} />
              </div>
            </div>
          </div>
        </div>
      ))}
    </div>
  )
}

export default OnboardingComponent
