export const checkCall = (cards, calledCard) => { // To check if all the last cards placed are equal
    const filteredCards = cards.filter(card => card != 'Joker')

    if(filteredCards.length > 0){        
        return filteredCards.every( card => card === calledCard )
    }
    return true
}

export default checkCall;