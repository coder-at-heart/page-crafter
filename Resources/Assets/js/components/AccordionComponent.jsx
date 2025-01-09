import React, { useState } from 'react'
import AccordionItem from './AccordionItem'
import Error from './Error'

const AccordionComponent = ({ data, errors, onChange }) => {
  const [items, setItems] = useState(data?.items || [])

  const handleItemChange = (index, newData) => {
    const updatedItems = [...items]
    updatedItems[index] = newData
    setItems(updatedItems)
    onChange({ items: updatedItems })
  }

  const handleAddItem = () => {
    const newItem = { title: '', text: { markdown: '', html: '' }, open: false }
    const updatedItems = [...items, newItem]
    setItems(updatedItems)
    onChange({ items: updatedItems })
  }

  const handleRemoveItem = index => {
    const updatedItems = items.filter((_, i) => i !== index)
    setItems(updatedItems)
    onChange({ items: updatedItems })
  }

  const handleMoveItem = (index, direction) => {
    const updatedItems = [...items]
    const targetIndex = index + direction
    if (targetIndex >= 0 && targetIndex < updatedItems.length) {
      const [movedItem] = updatedItems.splice(index, 1)
      updatedItems.splice(targetIndex, 0, movedItem)
      setItems(updatedItems)
      onChange({ items: updatedItems })
    }
  }

  const getErrorForIndex = index => {
    let indexErrors = {}
    if (typeof errors.items === 'object') {
      indexErrors = errors.items[index] ?? {}
    }
    return indexErrors
  }

  return (
    <div>
      {items.map((item, index) => (
        <div key={index} className='button-item'>
          <div className='d-flex justify-content-start align-items-center mt-2 border border-light-grey rounded-sm p-2 mb-3'>
            <div className='flex-grow-1 mr-3'>
              <AccordionItem
                data={item}
                errors={getErrorForIndex(index)}
                onChange={newData => handleItemChange(index, newData)}
                onRemove={() => handleRemoveItem(index)}
              />
            </div>
            <button
              onClick={() => handleMoveItem(index, -1)}
              disabled={index === 0}
              className='btn btn-secondary btn-sm mr-2'
            >
              <i className='fas fa-arrow-up'></i>
            </button>
            <button
              onClick={() => handleMoveItem(index, 1)}
              disabled={index === items.length - 1}
              className='btn btn-secondary btn-sm mr-2'
            >
              <i className='fas fa-arrow-down'></i>
            </button>
            <button
              onClick={() => handleRemoveItem(index)}
              className='btn btn-secondary btn-sm'
            >
              <i className='fas fa-trash'></i>
            </button>
          </div>
        </div>
      ))}
      <button onClick={handleAddItem} className='btn btn-secondary btn-sm'>
        <i className='fas fa-plus'></i>
      </button>
      <Error errors={errors?.items} />
    </div>
  )
}

export default AccordionComponent
