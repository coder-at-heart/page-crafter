import React, { useState } from 'react'
import Error from './Error'

const ButtonComponent = ({ data, errors, onChange, config }) => {
  const [localData, setLocalData] = useState({
    type: 'external',
    href: '',
    content: '',
    icon: '',
    ...data,
  })

  const [external, setExternal] = useState(
    localData.href && localData.type === 'external' ? localData.href : '',
  )

  const [email, setEmail] = useState(
    localData.href && localData.type === 'email' ? localData.href : '',
  )

  const [tel, setTel] = useState(
    localData.href && localData.type === 'tel' ? localData.href : '',
  )

  const [slug, setSlug] = useState(
    localData.href && localData.type === 'page' ? localData.href : '',
  )

  const [route, setRoute] = useState(
    localData.href && localData.type === 'route' ? localData.href : '',
  )

  const updateLocalData = updatedFields => {
    const updatedData = { ...localData, ...updatedFields }
    setLocalData(updatedData)
    onChange(updatedData)
  }

  const handleTypeChange = e => {
    const type = e.target.value
    const newData = { type }
    switch (type) {
      case 'external':
      case 'email':
      case 'tel':
        newData.href = ''
        break
      case 'route':
        newData.href = Object.keys(config.routes)[0]
        break
      case 'page':
        newData.href = config.pages[0].slug
        break
    }
    updateLocalData(newData)
  }

  const handleExternalChange = e => {
    setExternal(e.target.value)
    updateLocalData({ href: e.target.value })
  }

  const handleEmailChange = e => {
    setEmail(e.target.value)
    updateLocalData({ href: e.target.value })
  }

  const handleTelChange = e => {
    setTel(e.target.value)
    updateLocalData({ href: e.target.value })
  }

  const handleSlugChange = e => {
    setSlug(e.target.value)
    updateLocalData({ href: e.target.value })
  }

  const handleRouteChange = e => {
    setRoute(e.target.value)
    updateLocalData({ href: e.target.value })
  }

  const handleTextChange = e => {
    updateLocalData({ content: e.target.value })
  }

  const handleIconChange = e => {
    updateLocalData({ icon: e.target.value })
  }

  return (
    <div className='pagecraft-component__button d-flex flex-column'>
      <div className='d-flex mb-2 align-items-center justify-content-between'>
        <div className='mr-2'>
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

        <div className='mr-2'>
          <label>Button text</label>
          <input
            className='form-control'
            type='text'
            placeholder='Click me'
            onChange={handleTextChange}
            style={{ marginRight: '5px' }}
            value={localData.content}
          />
          <Error errors={errors.content} />
        </div>

        <div>
          <label>Icon</label>
          <select
            className='form-control'
            value={localData.icon}
            onChange={handleIconChange}
          >
            <option value=''>None</option>
            {Object.entries(config.icons).map(([index, icon]) => (
              <option key={index} value={icon}>
                {icon}
              </option>
            ))}
          </select>
        </div>
      </div>

      {localData.type === 'external' && (
        <div className='mb-2'>
          <label>External</label>
          <input
            className='form-control'
            type='text'
            placeholder='https://...'
            onChange={handleExternalChange}
            style={{ marginRight: '5px' }}
            value={external}
          />
          <Error errors={errors?.href} />
        </div>
      )}

      {localData.type === 'email' && (
        <div className='mb-2'>
          <label>Email</label>
          <input
            className='form-control'
            type='text'
            placeholder='someone@gmail.com'
            onChange={handleEmailChange}
            style={{ marginRight: '5px' }}
            value={email}
          />
          <Error errors={errors?.href} />
        </div>
      )}

      {localData.type === 'tel' && (
        <div className='mb-2'>
          <label>Telephone</label>
          <input
            className='form-control'
            type='text'
            placeholder='+1 123 567 8910'
            onChange={handleTelChange}
            style={{ marginRight: '5px' }}
            value={tel}
          />
          <Error errors={errors?.href} />
        </div>
      )}

      {localData.type === 'page' && (
        <div className='mb-2'>
          <label>Page</label>
          <select
            className='form-control'
            value={slug}
            onChange={handleSlugChange}
          >
            {config.pages.map(page => (
              <option key={page.slug} value={page.slug}>
                {page.title}
              </option>
            ))}
          </select>
        </div>
      )}

      {localData.type === 'route' && (
        <div className='mb-2'>
          <label>Route</label>
          <select
            className='form-control'
            value={route}
            onChange={handleRouteChange}
          >
            {Object.entries(config.routes).map(([key, value]) => (
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

export default ButtonComponent
