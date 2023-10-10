let theError = {error:false, msg:null};

let errors = [
    {id:1, msg:'Fill in all fields'},
    {id:2, msg:"Passwords don't match"},
    {id:3, msg:"Username: Max 12 characters"},
    {id:4, msg:"Password: Min 8 characters"}
]

const handleErrors = (username, password, confirmPassword) => {
    if(!username || !password || !confirmPassword){
        
        theError.error = true
        theError.msg = errors[0].msg

        return theError

        
    } else if( username.length > 12) {

        theError.error = true
        theError.msg = errors[2].msg

        return theError

    } else if( password.length < 8){

        theError.error = true
        theError.msg = errors[3].msg

        return theError

    } else if(password !== confirmPassword) {

        theError.error = true
        theError.msg = errors[1].msg

        return theError
    }

    theError = {error:false, msg:null}

    return theError
}

export default handleErrors;