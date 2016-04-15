<?php
    namespace library\kernel\core;
    use \Exception;
    
    class Dispatch{
        // SINGLETON VARIABLE
        private $singleton              = false;
        // CONTROLLER VARIABLES
        private $controllerDefault      = false;
        private $controllerName         = false;
        private $controller             = false;
        // ACTION VARIABLES
        private $isActionDefault        = false;
        private $actionDefault          = false;
        private $action                 = false;
        // QUERY STRING
        private $queryString            = array();
        private $queryStringCount       = 0;
        
        // CONSTRUCT AND DESTRUCT FUNCTIONS
        private function __construct(){
            // SETTING UP DEFAULT CONTROLLER/ACTION
            //$this->controllerDefault = NAMESPACE_CONTROLLERS . ucwords(FRAMEWORK_NAME) . 'Controller';
            $this->controllerDefault = NAMESPACE_CONTROLLERS . ucwords(FRAMEWORK_NAME);
            $this->actionDefault = 'index';
        }
        
        // PUBLIC CREATE/BUILD FUNCTIONS
        public static function create($url){
            $dispatch = new Dispatch();
            if(!class_exists($dispatch->getControllerDefault())){
                throw new Exception('Main class not found', ERROR_FW_CONTROLLER_NOT_FOUND);
            }else if(!method_exists($dispatch->getControllerDefault(), strtolower(FRAMEWORK_NAME))){
                throw new Exception('Non esiste una pagina home', 666);
            }
            return ($dispatch->build($url));
        }
        public function build($url){
            if(!($this->choose($url))){
                throw new Exception('Combination Controller/Action not found', 666);
            }
            $this->setSingleton(new $this->controller());
            return ($this);
        }
        
        // CHOOSE CONTROLLER/ACTION FUNCTIONS
        private function choose($url){
            // CHOOSING RIGHT CONTROLLER/ACTION COMBINATION
            if($url === false){
                // NO URL FOUND
                $this->setController($this->controllerDefault);
                $this->setAction(strtolower(FRAMEWORK_NAME));
                return (true);
            }
            // URL FOUND
            // TRIM SLASHED TO EXCLUDE EMPTY PARAMETERS
            $url = trim($url, "\/\\");
            // EXPLODE URL BY SLASHES
            $url = explode('/', $url);
            // SETTING UP CONTROLLER NAME AND IT'S REAL CLASS PATH
            $this->setControllerName(array_shift($url));
            //$controllerClassPath = NAMESPACE_CONTROLLERS . ucfirst($this->controllerName . 'Controller');
            $controllerClassPath = NAMESPACE_CONTROLLERS . ucfirst($this->controllerName);
            // CHECK IF CONTROLLER EXISTS
            if(class_exists($controllerClassPath)){
                // CONTROLLER EXISTS
                // SETTING UP CONTROLLER AT DEFAULT VALUES FOR THIS CASE
                $this->setController($controllerClassPath);
                $this->setAction($this->getActionDefault());
                $this->setIsActionDefault(true);
                // FETCH URL SEEKING MORE PARAMETERS
                if(count($url)>0){
                    // ACTION PRESENT IN THE URL
                    $this->setAction(array_shift($url));
                    $this->setIsActionDefault(false);
                    if(count($url)>0){
                        // QUERY STRING PRESENT IN THE URL
                        $this->setQueryString($url);
                    }
                }
                // CHECK IF METHOD EXISTS
                if(method_exists($this->getController(), $this->getAction())){
                    // METHOD EXISTS
                    return (true);
                }
            }else{
                // CONTROLLER DOESN'T EXIST
                // SETTING UP CONTROLLER AT DEFAULT VALUES FOR THIS CASE
                $this->setController($this->controllerDefault);
                $this->setAction($this->controllerName);
                // SETTING UP QUERY STRING
                $this->setQueryString($url);
                // CHECK IF METHOD EXISTS
                if(method_exists($this->getController(), $this->getAction())){
                    // METHOD EXISTS
                    return (true);
                }
            }
            return (false);
        }
        
        // SET FUNCTIONS
        private function setSingleton($singleton){$this->singleton = $singleton;}
        private function setIsActionDefault($isDefault){if(is_bool($isDefault)){$this->isActionDefault = $isDefault;}}
        private function setAction($action){$this->action = $action;}
        private function setController($controller){$this->controller = $controller;}
        private function setControllerName($controllerName){$this->controllerName = $controllerName;}
        private function setQueryString($queryString){
            $this->queryString = $queryString;
            $this->setQueryStringCount($this->getQueryStringCount()+1);
        }
        private function setQueryStringCount($queryStringCount){$this->queryStringCount = $queryStringCount;}
        
        // GET FUNCTIONS
        public function getSingleton(){return ($this->singleton);}
        public function getIsActionDefault(){return ($this->isActionDefault);}
        public function getAction(){return ($this->action);}
        public function getActionDefault(){return ($this->actionDefault);}
        public function getController(){return ($this->controller);}
        public function getControllerName(){return ($this->controllerName);}
        public function getControllerDefault(){return ($this->controllerDefault);}
        public function getQueryString(){return ($this->queryString);}
        public function getQueryStringCount(){return ($this->queryStringCount);}
        
        // OTHER PRIVATE VARIABLE FUNCTIONS
        public function addQueryStringByPos($value, $index, $defaultValues){
            if($this->getQueryStringCount() < $index){
                $this->queryStringFillUsingDefaults($this->getQueryStringCount(), $index, $defaultValues);
            }
            array_splice($this->queryString, $index, 0, array($value));
        }
        private function queryStringFillUsingDefaults($from, $to, $defaultValues){
            for($i=$from;$i<$to;$i++){
                if(array_key_exists($i, $defaultValues) && !array_key_exists($i, $this->queryString)){
                    $this->queryString[$i] = $defaultValues[$i];
                }
            }
        }
        public function appendQueryString($queryString){$this->queryString[] = $queryString;}
    }