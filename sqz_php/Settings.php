<?php
class Settings
{
	public $MAX_N_QUESTS = 999;
	public $DEFT_N_ANS = 4;
	public $nQuest;
	public $nAns;
	public $bChoiceSort;
	public $bQuestSort;
	public $bDIV;

	public function Settings() {
		$nQuest = $this->$MAX_N_QUESTS;
		$nAns = $this->$DEFT_N_ANS;
		$bQuestSort = true;
		$bChoiceSort = true;
		$bDIV = true;
	}
}
?>