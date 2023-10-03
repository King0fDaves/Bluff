export const numToLetter = (num) => {
    const letterNums = [
        11, 12, 13, 1
    ]

    const letterNumObj = [
        {id:1, letter:"J"},
        {id:2, letter:"Q"},
        {id:3, letter:"K"},
        {id:4, letter:"A"},
    ]

    if(letterNums.includes(num)){
        const index = letterNums.indexOf(num)
        const letter = letterNumObj[index]
        return letter.letter
    } else {
        return num
    }

}

export default numToLetter;