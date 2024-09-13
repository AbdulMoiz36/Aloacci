<div className="w-full flex justify-center items-center">
      <div className="lg:p-10 md:p-10 py-10 px-3 shadow-2xl border-2 my-10 w-5/6 md:w-4/6 lg:w-3/6 flex flex-col items-center gap-10">
        <div>
          <h1 className="text-center text-4xl font-bold mb-3">Login</h1>
          <p>
            Don't have an account?
           <a href="signup.php">   
               <span className="text-green-600 ml-1 font-semibold underline">
                   Register
                </span>
            </a>
                
          </p>
        </div>
       
        <div>
          <form className="flex flex-col gap-5">
            <input
              type="email"
              id="email"
              placeholder="Email"
              className="px-3 py-4 border border-green-500 outline-yellow-500 rounded-md w-full md:w-96"
            />
            <div className="relative">
              <input
                type="password"
                id="password"
                placeholder="Password"
                className="px-3 py-4 border border-green-500 outline-yellow-500 rounded-md pr-12 w-full md:w-96"
              />
             
            </div>
            <button
              type="submit"
              className="px-5 py-4 text-white bg-lime-500 rounded-md font-semibold hover:bg-lime-600 transition ease-in-out duration-300 hover:drop-shadow-xl "
            >
              Login
            </button>
          </form>
        </div>
      </div>
    </div>