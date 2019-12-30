<?php
/*
40 じゃんけんを作成しよう！
下記の要件を満たす「じゃんけんプログラム」を開発してください。

要件定義
・使用可能な手はグー、チョキ、パー
・勝ち負けは、通常のじゃんけん
・PHPファイルの実行はコマンドラインから。

ご自身が自由に設計して、プログラムを書いてみましょう！
*/

/*
修正点
・check関数の中でelseifは使用せず全てif文に修正
・0～2以外の数字が入力されているかのチェックはissetを使用
・厳密演算子を使用し空文字のチェック
・inputHand関数のグーチョキパーを定数を使用して出力
*/

const HAND_TYPE = array("グー", "チョキ", "パー");
const JUDGE_TYPE = array("あいこ", "勝ち", "負け");

function playJanken() {
	$playerHand = (int)inputHand();
    $pcHand = getPcHand();
    $result = judge($playerHand, $pcHand);
    
    //結果を表示、あいこなら再度playJankenを呼ぶ
	switch ($result) {
		case 0:
			echo "あいこです。もう一度！" . PHP_EOL;
    		return playJanken();
    	case 1:
    		echo "あなたの勝ちです。" . PHP_EOL;
    		break;
    	case 2:
    		echo "あなたの負けです。" . PHP_EOL;
    		break;
    }
    echo PHP_EOL;
	
	return continueGame();
}

function inputHand() {
	for($i = 0; $i < 3; $i++) {
		echo $i . ":" . HAND_TYPE[$i] . " ";
	}
	echo PHP_EOL;
	echo "0, 1, 2の中から選んで入力してください。" . PHP_EOL;
    $input = trim(fgets(STDIN));
	echo "playerHand:" . $input . PHP_EOL;
    if(!check($input)) {
        return inputHand();
    }
    return $input;
}

function getPcHand() {
	$myHand = array_rand(HAND_TYPE);
	echo "pcHand:" . $myHand . PHP_EOL;
	return $myHand;
}

function judge($playerHand, $pcHand) {
	$judge = ($playerHand - $pcHand + 3) % 3;
	if ($playerHand === $pcHand) {
		return 0;
	} elseif ($judge === 1) {
		return 2;
	} elseif ($judge === 2) {
		return 1;
	} 
}

function check($playerHand) {
    //空文字の場合
    if ($playerHand === '') {
        echo "※未入力です※" . PHP_EOL;
        echo PHP_EOL;
        return false;
    }

    //数字以外が入力されている場合
    if (!is_numeric($playerHand)) {
    	echo "※数字以外が入力されています※" . PHP_EOL;
    	echo PHP_EOL;
    	return false;
    }

    //0～2以外が入力されている場合
    if (!isset(HAND_TYPE[$playerHand])) {
        echo "※範囲外の番号が入力されています※" . PHP_EOL;
        echo PHP_EOL;
        return false;
    }
    return true;
}

function continueGame() {
	echo "ゲームを続けますか？ 0:はい 1:いいえ" . PHP_EOL;
	$answer = trim(fgets(STDIN));
	echo PHP_EOL;
	if ($answer === "0") {
		return playJanken();
	} elseif ($answer === "1") {
		echo "ゲームを終了します";
		return;
	}
}

playJanken();

?>