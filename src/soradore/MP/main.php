<?       

namespace soradore\MP;


/* Base */
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
/* Events */
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\scheduler\PluginTask;

class main extends PluginBase implements Listener{

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onJoin(PlayerJoinEvent $ev){
		$task = new MsgTask($this);
		$this->getServer()->getScheduler()->scheduleRepeatingTask($task, 15);
	}
}

class MsgTask extends PluginTask{

	private $count = 0;
	const MAX = 10;

	public $msg = [
		          "こんにちは、ようこそ",
		          "Hello, Welcome."
	              ];

	public function __construct($plugin){
		parent::__construct($plugin);
		$this->msg = $this->getMsg();
	}


	public function onRun(int $tick){
		$count = $this->count;
		$msg = $this->msg;
		
		$msg = str_repeat(" ", self::MAX) . $msg . str_repeat(" ", self::MAX);
		$msg = mb_substr($msg, $count, self::MAX);
		Server::getInstance()->broadcastPopup( "§a" . $msg . " \n\n\n\n");
		$this->increment();
	} 


	public function getMsg($key = 0){
		return $this->msg[$key];
	}


	private function increment(){
		$this->count += 1;
	}


}