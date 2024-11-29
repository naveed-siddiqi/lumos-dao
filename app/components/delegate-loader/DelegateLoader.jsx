const DelegateLoader = () => {
    return (
      <div className="flex flex-col sm:flex-row justify-between sm:items-end gap-4 p-4 helvetica-font">
        <div className="flex flex-col gap-2">
          <div className="w-16 h-4 bg-gray-200 animate-pulse rounded"></div>
          <div className="flex items-center gap-2">
            <div className="w-[50px] h-[50px] bg-gray-200 animate-pulse rounded-full"></div>
            <div className="w-24 h-6 bg-gray-200 animate-pulse rounded"></div>
          </div>
        </div>
        
        <div className="flex flex-col gap-2">
          <div className="w-16 h-4 bg-gray-200 animate-pulse rounded"></div>
          <div className="flex items-center gap-2">
            <div className="w-[50px] h-[50px] bg-gray-200 animate-pulse rounded-full"></div>
            <div className="w-24 h-6 bg-gray-200 animate-pulse rounded"></div>
          </div>
        </div>
        
        <div>
          <div className="w-40 h-10 bg-gray-200 animate-pulse rounded"></div>
        </div>
      </div>
    );
  };
  
  export default DelegateLoader;