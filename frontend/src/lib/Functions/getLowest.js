export const getLowest = (num) => {
    const theVal = num - 1;

    if(theVal < 1){
        return 13
    }

    return theVal;
}

export default getLowest;