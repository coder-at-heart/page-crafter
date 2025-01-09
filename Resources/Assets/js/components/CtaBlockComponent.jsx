import React, { useState } from 'react'
import ButtonComponent from './ButtonComponent'
import Error from './Error'

const ButtonBlock = ({ data, errors, config, onChange }) => {
  const generateHashId = () => {
    return `btn-${Math.random()
      .toString(36)
      .slice(2, 7)}`
  }

  const [buttons, setButtons] = useState(
    () =>
      data?.buttons?.map((button, index) => ({
        ...button,
        id: generateHashId(),
      })) || [],
  )

  const handleButtonChange = (index, newData) => {
    buttons[index] = newData
    setButtons(buttons)
    onChange({ buttons: buttons })
  }

  const handleAddButton = () => {
    const updatedButtons = [
      ...buttons,
      {
        id: generateHashId(),
        href: '',
        content: '',
        type: 'external',
        icon: '',
      },
    ]
    setButtons(updatedButtons)
    onChange({ buttons: updatedButtons })
  }

  const handleRemoveButton = index => {
    const updatedButtons = buttons.filter((_, i) => i !== index)
    setButtons(updatedButtons)
    onChange({ buttons: updatedButtons })
  }

  const handleMoveButton = (index, direction) => {
    const updatedButtons = [...buttons]
    const targetIndex = index + direction
    if (targetIndex >= 0 && targetIndex < updatedButtons.length) {
      const [movedItem] = updatedButtons.splice(index, 1)
      updatedButtons.splice(targetIndex, 0, movedItem)
      setButtons(updatedButtons)
      onChange({ buttons: updatedButtons })
    }
  }

  const getErrorForIndex = index => {
    let indexErrors = {}
    if (typeof errors.buttons === 'object') {
      indexErrors = errors.buttons[index] ?? {}
    }
    return indexErrors
  }

  return (
    <div>
      {Array.isArray(buttons) &&
        buttons.map((button, index) => (
          <div key={button.id} className='button-item'>
            <div className='d-flex justify-content-start align-items-center mt-2 border border-light-grey rounded-sm p-2 mb-3'>
              <div className='flex-grow-1 mr-2'>
                <ButtonComponent
                  data={button}
                  config={config}
                  errors={getErrorForIndex(index)}
                  onChange={newData => handleButtonChange(index, newData)}
                />
              </div>
              <button
                onClick={() => handleMoveButton(index, -1)}
                disabled={index === 0}
                className='btn btn-secondary btn-sm mr-2'
              >
                <i className='fas fa-arrow-up'></i>
              </button>
              <button
                onClick={() => handleMoveButton(index, 1)}
                disabled={index === buttons.length - 1}
                className='btn btn-secondary btn-sm mr-2'
              >
                <i className='fas fa-arrow-down'></i>
              </button>
              <button
                onClick={() => handleRemoveButton(index)}
                className='btn btn-secondary btn-sm'
              >
                <i className='fas fa-trash'></i>
              </button>
            </div>
          </div>
        ))}
      <button onClick={handleAddButton} className='btn btn-secondary btn-sm'>
        <i className='fas fa-plus'></i>
      </button>
      <Error errors={errors?.buttons} />
    </div>
  )
}

export default ButtonBlock
