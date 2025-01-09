import React from 'react'

export default function Error({ errors }) {
  return (
    <>
      {errors &&
        Array.isArray(errors) &&
        errors
          .filter(error => typeof error === 'string') // Only include strings
          .map((error, i) => (
            <div className='error' key={i}>
              <p>{error}</p>
            </div>
          ))}
    </>
  )
}
