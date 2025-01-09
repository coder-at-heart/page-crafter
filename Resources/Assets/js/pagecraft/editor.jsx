import React, { useEffect, useRef, useState } from 'react'
import ReactDOM from 'react-dom'
import axios from 'axios'
import { DndProvider, useDrag, useDrop } from 'react-dnd'
import { HTML5Backend } from 'react-dnd-html5-backend'
import allComponents from './compontRegistry'

export default function PageCraft({
  mode,
  componentsToUse,
  page,
  saveUrl,
  destroyUrl,
  token,
  statuses,
  fixed,
}) {
  const statusesArray = JSON.parse(statuses)

  // These are the components that make up the page
  const [components, setComponents] = useState([])
  const [pageTitle, setPageTitle] = useState('')
  const [pageSlug, setPageSlug] = useState('')
  const [pageStatus, setPageStatus] = useState('')
  const [isSaving, setIsSaving] = useState(false)
  const [isDeleting, setIsDeleting] = useState(false)
  const [modalMessage, setModalMessage] = useState('')
  const [modalType, setModalType] = useState('success')

  // We need to store this data separately so we don't cause a refresh everytime the data is updated.
  const pageData = useRef({})

  // These are the templates that are allowed for this page type
  const allowedComponents = useRef({})
  const pageObject = useRef({})
  const [initialised, setInitialised] = useState(false)

  // Note: No dependencies, means this runs once.
  useEffect(() => {
    // Let's build up a list of allowed components for this template type
    JSON.parse(componentsToUse).forEach(componentToUse => {
      allowedComponents.current[componentToUse.type] = {
        name: componentToUse.name,
        config: componentToUse.config,
        variants: componentToUse.variants,
        component: allComponents[componentToUse.type],
      }
    })

    pageObject.current = JSON.parse(page)

    if (Array.isArray(pageObject.current.content)) {
      pageObject.current.content.forEach(block => {
        addComponent(block.type, block.data, block?.variant)
      })
    } else {
      console.error('pageObject.current.content is not an array')
    }

    setPageTitle(pageObject.current.title)
    setPageSlug(pageObject.current.slug)
    setPageStatus(pageObject.current.status)

    if (components.length === 0 && mode === 'create') {
      addComponent('text')
    }

    setInitialised(true)
  }, [])

  const addComponent = (type = 'text', data = {}, variant = '') => {
    // ake up an id so we can index the data
    const id = `${Date.now()}_${Math.random()
      .toString(36)
      .slice(2, 11)}`
    updateComponentData(id, data)
    updateComponentVariant(id, variant)
    setComponents(prev => [...prev, { id, type, errors: {} }])
  }

  const removeComponent = id => {
    setComponents(prev => prev.filter(comp => comp.id !== id))
  }

  const updateComponentData = (id, data) => {
    if (!pageData.current[id]) {
      pageData.current[id] = { data: null, variant: null }
    }

    pageData.current[id].data = data
  }

  const updateComponentVariant = (id, data) => {
    if (!pageData.current[id]) {
      pageData.current[id] = { data: null, variant: null }
    }

    pageData.current[id].variant = data
  }

  const destroy = () => {
    setIsDeleting(true)

    axios({
      method: 'DELETE',
      url: destroyUrl,
      headers: {
        'X-CSRF-TOKEN': token,
      },
    })
      .then(() => {})
      .finally(() => {
        setIsDeleting(false)
        window.location.href = '/admin/pagecraft'
      })
  }

  const save = () => {
    setIsSaving(true)

    const content = []
    components.map(function(item) {
      content.push({
        id: item.id,
        type: item.type,
        data: pageData.current[item.id].data,
        variant: pageData.current[item.id].variant,
      })
    })

    pageObject.current.content = content
    pageObject.current.title = pageTitle
    pageObject.current.slug = pageSlug
    pageObject.current.status = pageStatus

    axios({
      method: 'PUT',
      url: saveUrl,
      data: pageObject.current,
      headers: {
        'X-CSRF-TOKEN': token,
      },
    })
      .then(response => {
        const errors = response.data.errors
        const newComponents = components.map(component => {
          const componentErrors = (errors && errors[component.id]) || {}
          return { ...component, errors: componentErrors }
        })
        setComponents(newComponents)

        if (response.data?.success) {
          setModalType('success')
          setModalMessage('The page has been saved successfully!')
        } else {
          setModalType('error')
          setModalMessage(
            'There were errors saving the page. Please review and try again.',
          )
        }
      })
      .catch(error => {
        console.error(error)
        setModalType('error')
        setModalMessage('An unexpected error occurred. Please try again later.')
      })
      .finally(() => {
        setIsSaving(false)
        $('#status-modal').modal('show')
      })
  }

  const moveComponent = (dragIndex, hoverIndex) => {
    const updatedComponents = [...components]
    const [movedItem] = updatedComponents.splice(dragIndex, 1)
    updatedComponents.splice(hoverIndex, 0, movedItem)
    setComponents(updatedComponents)
  }

  const handleTitleChange = e => {
    setPageTitle(e.target.value)
  }

  const handlePageStatus = e => {
    setPageStatus(e.target.value)
  }

  const VariantsDropdown = ({ variants, id }) => {
    return (
      <select
        className=' form-control text-capitalize'
        defaultValue={pageData.current[id].variant}
        onChange={e => {
          updateComponentVariant(id, e.target.value)
        }}
      >
        {Object.entries(variants).map(([key, value]) => (
          <option key={key} value={key}>
            {value}
          </option>
        ))}
      </select>
    )
  }

  const DraggableComponent = ({ component, index }) => {
    const ref = React.useRef(null)

    const [, drop] = useDrop({
      accept: 'component',
      hover: item => {
        if (item.index !== index) {
          moveComponent(item.index, index)
          item.index = index
        }
      },
    })

    const [{ isDragging }, drag] = useDrag({
      type: 'component',
      item: { index },
      collect: monitor => ({
        isDragging: monitor.isDragging(),
      }),
    })

    drag(drop(ref))

    if (!initialised) {
      return null
    }
    const Component = allowedComponents.current[component.type].component
    const ComponentName = allowedComponents.current[component.type].name

    const dragHandleRef = React.useRef(null)

    const variants = allowedComponents.current[component.type].variants

    return (
      <div
        ref={ref}
        className='pagecraft-component'
        style={{ opacity: isDragging ? 0.5 : 1 }}
      >
        <div className='d-flex justify-content-between align-items-center mt-1 mb-2'>
          <h4 className='me-auto'>{ComponentName}</h4>
          <div className='flex-grow-1 mr-2'></div>
          {variants &&
            typeof variants === 'object' &&
            Object.keys(variants).length > 0 && (
              <div className='mr-2'>
                <VariantsDropdown variants={variants} id={component.id} />
              </div>
            )}
          {fixed !== 'yes' && (
            <div
              className='btn-group'
              role='group'
              aria-label='Component Actions'
            >
              <button ref={dragHandleRef} className='btn btn-secondary'>
                <i className='fas fa-grip-lines'></i>
              </button>
              <button
                className='btn btn-secondary'
                disabled={index === 0}
                onClick={() => moveComponent(index, index - 1)}
              >
                <i className='fas fa-arrow-up'></i>
              </button>
              <button
                className='btn btn-secondary'
                disabled={index === components.length - 1}
                onClick={() => moveComponent(index, index + 1)}
              >
                <i className='fas fa-arrow-down'></i>
              </button>
              <button
                className='btn btn-secondary'
                onClick={() => removeComponent(component.id)}
              >
                <i className='fas fa-trash'></i>
              </button>
            </div>
          )}
        </div>

        <Component
          data={pageData.current[component.id].data}
          errors={component.errors}
          config={allowedComponents.current[component.type].config}
          onChange={data => updateComponentData(component.id, data)}
        />
      </div>
    )
  }

  return (
    <DndProvider backend={HTML5Backend}>
      <div className='pagecraft'>
        <div className='d-flex justify-content-end'>
          <div className='d-flex flex-column flex-grow-1'>
            <label htmlFor='pageTitle'>Page title</label>
            <input
              name='title'
              className='form-control'
              value={pageTitle}
              onChange={handleTitleChange}
            />
          </div>

          <div className='d-flex flex-column ml-2'>
            <label htmlFor='status'>Status</label>
            <select
              name='status'
              className=' form-control text-capitalize'
              value={pageStatus}
              onChange={handlePageStatus}
            >
              {statusesArray.map((status, index) => {
                return (
                  <option key={index} value={status}>
                    {status}
                  </option>
                )
              })}
            </select>
          </div>

          {fixed !== 'yes' && (
            <button
              className='btn btn-danger btn-sm w-5 ml-2'
              disabled={isDeleting}
              onClick={() => $('#delete-page-modal').modal()}
            >
              <span
                className={`spinner-border spinner-border-sm ml-2 ${
                  isDeleting ? '' : 'd-none'
                }`}
                role='status'
                aria-hidden='true'
              ></span>
              <i className='fa fa-trash'></i>
              <br />
              <span className='button-text'>{isDeleting ? '' : 'Delete'}</span>
            </button>
          )}
          <button
            className='btn btn-primary btn-sm ml-2 w-5'
            disabled={isSaving}
            onClick={e => {
              e.preventDefault()
              save()
            }}
          >
            <span
              className={`spinner-border spinner-border-sm mr-2 ${
                isSaving ? '' : 'd-none'
              }`}
              role='status'
              aria-hidden='true'
            ></span>
            <i className='fa fa-save' data-id='{{ $user->id }}'></i>
            <br />
            <span className='button-text'>{isSaving ? '' : 'Save'}</span>
          </button>
          {fixed !== 'yes' && (
            <button
              className='btn btn-secondary btn-sm ml-2 w-5'
              onClick={() => $('#page-components-modal').modal()}
            >
              <i className='fa fa-plus'></i>
              <br />
              <span className='button-text'>Add</span>
            </button>
          )}
        </div>

        <div
          className='modal fade'
          id='delete-page-modal'
          role='dialog'
          aria-labelledby='modelTitleId'
          aria-hidden='true'
        >
          <div className='modal-dialog' role='document'>
            <div className='modal-content'>
              <div className='modal-header align-self-center'>
                <h5 className='modal-title '>
                  Click a component to add to the page
                </h5>
              </div>
              <div className='modal-body'>
                Deleting a page cannot be undone, would you like to continue?
                <input type='hidden' value='' className='js-delete-id' />
              </div>
              <div className='modal-footer'>
                <button
                  type='button'
                  className='btn btn-secondary'
                  data-dismiss='modal'
                >
                  Close
                </button>
                <button
                  className='btn btn-danger js-confirm-delete'
                  onClick={() => destroy()}
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>

        <div
          className='modal fade'
          id='page-components-modal'
          tabIndex='-1'
          role='dialog'
          aria-labelledby='modelTitleId'
          aria-hidden='true'
        >
          <div className='modal-dialog' role='document'>
            <div className='modal-content'>
              <div className='modal-header align-self-center'>
                <h5 className='modal-title '>
                  Click a component to add to the page
                </h5>
              </div>
              <div className='modal-body'>
                <div className='d-flex justify-content-between flex-wrap'>
                  {Object.keys(allowedComponents.current).map(type => (
                    <button
                      data-dismiss='modal'
                      className='btn btn-secondary btn-sm mb-2'
                      key={type}
                      onClick={() => addComponent(type)}
                    >
                      {allowedComponents.current[type].name}
                    </button>
                  ))}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div
          className='modal fade'
          id='status-modal'
          role='dialog'
          aria-labelledby='statusModalTitle'
          aria-hidden='true'
        >
          <div className='modal-dialog' role='document'>
            <div className='modal-content'>
              <div
                className={`modal-header ${
                  modalType === 'success' ? 'bg-success' : 'bg-danger'
                }`}
              >
                <h5 className='text-white modal-title' id='statusModalTitle'>
                  {modalType === 'success' ? 'Success' : 'Error'}
                </h5>
                <button
                  type='button'
                  className='close'
                  data-dismiss='modal'
                  aria-label='Close'
                >
                  <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div className='modal-body'>{modalMessage}</div>
              <div className='modal-footer'>
                <button
                  type='button'
                  className='btn btn-primary'
                  data-dismiss='modal'
                >
                  OK
                </button>
              </div>
            </div>
          </div>
        </div>

        <div className='mt-3'>
          {components.map((component, index) => (
            <DraggableComponent
              component={component}
              index={index}
              key={component.id}
            />
          ))}
        </div>
      </div>
    </DndProvider>
  )
}

const mount = document.getElementById('pagecraft-editor')

if (mount) {
  ReactDOM.render(
    <PageCraft
      mode={mount.dataset.mode}
      componentsToUse={mount.dataset.components}
      page={mount.dataset.page}
      saveUrl={mount.dataset.save_url}
      destroyUrl={mount.dataset.destroy_url}
      token={mount.dataset.token}
      statuses={mount.dataset.statuses}
      fixed={mount.dataset.fixed}
    />,
    mount,
  )
}
