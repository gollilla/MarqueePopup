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
		$player = $ev->getPlayer();
		$task = new MsgTask($this, $player, "適当なメッセージ, §a適当すぎるメッセージ, §bめっちゃ適当なメッセージ");
		$this->getServer()->getScheduler()->scheduleRepeatingTask($task, 15);
	}
}

class MsgTask extends PluginTask{

	private $count = 0;
	private $color = "§f";
	const MAX = 13;


	public function __construct($plugin, $player, $msg){
		parent::__construct($plugin);
		$this->player = $player;
		$this->msg = str_repeat(" ", self::MAX) . $msg . str_repeat(" ", self::MAX);
	}


	public function onRun(int $tick){
		$count = $this->count;
		$msg = $this->msg;
		if($count == mb_strlen($msg)) $this->getHandler()->cancel();
		$msg = mb_substr($msg, $count, self::MAX);

		$tmpC = mb_strpos($msg, "§");
		if($tmpC !== false && $tmpC == 0){
			$color = mb_substr($msg, $tmpC, 2);
			$this->setColor($color);
		}

		$this->player->sendPopup($this->color . $msg . " \n\n\n\n");
		$this->increment();
	} 


	public function setColor($color = "§f"){
		$this->color = $color;
	}


	private function increment(){
		$this->count += 1;
	}


}
