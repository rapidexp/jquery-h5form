/**
 *  Html5 Form Vlidation Plugin for IE - jQuery plugin
 *  Version--laster
 *
 *  Author: by Yoshiyuki Mikomde http://www.rapidexp.com
 *
 *  Copyright (c) 2012 Yoshiyuki Mikome (http://www.rapidexp.com)
 *  Dual licensed under the MIT (MIT-LICENSE.txt)
 *  and GPL (GPL-LICENSE.txt) licenses.
 *
 *  Built for jQuery library
 *	http://jquery.com
 *
 */



HTML5 フォームバリデーションをすべてのブラウザで有効にし、Operaと同等*1 の表現を
与えるプラグインです。

 * ChromeやSafariでは日付関係のコントロールを拡張します。

 * FireFoxでは日付と数値のコントロールを拡張します。

 * IEではそれらに加え、必須とスペースホルダー、オートフォーカスの属性、EmailやURL、
   正規表現パターンのバリデーションをすべて有効にします。
   エラーは、他のモダンブラウザと同様のフキダシ形状のメッセージで知らせます。

 * Operaでは結果として何もしません。

これらは、input要素が対応オブジェクトを持っているかで判断していますので、
今後のブラウザのバージョンや未知のブラウザに対しても、ほぼメンテナンス
フリー*2 で対応します。


また、IEのSubmit時のバグをすべて改善してButton要素の利用を可能にします。

 * SubmitタイプのButton要素をクリックしたとき、該当buttonの値（value）を送信せず、
   すべてのbuttonの内容（context）を送信する。

 * TextタイプのInput要素でEnterを押しても、Button要素のSubmitの値は送信されない。

 * TextタイプのInput要素が１つだけのときは、Input要素であってもSubmitの値はEnterで
   送信されない。

 * Button要素のタイプのデフォルトがSubmitではなくButtonである。


注意

 *1 グローバル日時（Datetime）はW3CのDralft仕様を厳格に解釈したため、OperaのUIとは
    異なります。

 *2 日付にカレンダーUIを持っているかはブラウザの種別判定に依存しています。
    この部分はブラウザバージョンアップ時に判定を変更の必要が生じます。




インストール
============================

HTMLヘッダに次のコードを組み込むだけです。

  <link rel="stylesheet" type="text/css" href="css/jquery.h5form-x.x.css" />
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script type="text/javascript" src="jquery.h5form-x.x.min.js"></script>

  <script type="text/javascript">
  $(function() {
    $('form').h5form();
  });
  </script>


※ jQuery 1.7はIE6/7でエラーが発生します。




オプション
============================

あるコントールの選択結果により他のコントールのRequiedを変化させるなど
ロード時とサブミット時で必要なバリデーションの有無が変わる場合は、
サブミット前に再スキャンが必要なコントロールをオプション dinamicHtml で
指定してください。


  $('form').h5form({ dinamicHtml: '[name="password"]' });




jQuery UI
============================

DateやRangeタイプに対応するには、jQuery UIをヘッダに組み込んでください。

  <link rel="stylesheet" type="text/css" href="../../css/smoothness/jquery-ui-custom.css" />
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

InputのタイプをDateやRangeにするだけで、必要最低限のオプションをセットした
DatepickerとSlider がハンドルされます。
jQuery UI が組み込まれているかどうか判定していますので特に追加の設定はありません。





謝辞
============================

このプラグインは jquery.html5form-1.5.js から派生しました。
当初からコンセプトの異なる方向への改変でしたが、バージョン2.0において設計
方針の大幅な変更を行い、コード的にも明らかな別プロジェクトとなったと判断し、
ヘッダの著作も単独表示へ変更させていただきました。
一部の変数名や構造にhtml5formの名残りが残っています。


ベースプロジェクト: jquery.html5form-1.5.js
Copyright (c) 2010 Matias Mancini (http://www.matiasmancini.com.ar)




改変履歴
============================

Version 2.2		(2012-06-15)

 * input要素のないフォームでのエラーを修正
 * submitに関するIEのバグを吸収


Version 2.1		(2012-06-12)

 * jQuery UIの判定が2,0から抜け落ちていた
 * textareaのmaxlength制御が2.0から抜け落ちていた
 * type値の大文字表記を許容


Version 2.0		(2012-06-10)

 * 各コントロールの編集時のエラーを対応ブラウザではCustomValidityに設定する
 * 非対応ブラウザもCustomValidityを擬似シミュレートする
 * ロード時にコントールごとに判定し、必要なコントロールのみにイベント追加
 * サブミット時は判定済みのエラーを表示するのみとする
 * ダイナミックHTMLのためのサブミット前の再スキャンはオプション
 * 一部を除きブラウザの種別とバージョン判定を不要にした
 * allBrowsersオプションは消滅


Version 1.3		(2012-06-07)

 * type=range に対応（jQuery UI を利用）
 * いつのまにかIE7未満でエラーが発生していた


Version 1.2.1	(2012-06-06)

 * datetimeのタイムゾーン付き初期値をIEで読み取れないのを修正


Version 1.2		(2012-06-05)

 * スクリプトファイル名を再変更
 * type=number に対応
 * type=time に対応
 * type=date, datetime, datetime-local に対応（jQuery UI を利用）
 * textarea の maxlength を改善
 * responseDivのコンテナをspanに変更


Version 1.1		(2012-05-31)

 * リアルタイムなバリデーションに対応


Version 1.0		(2012-05-26)

 * ダイナミックrequiedに対応
 * pattern属性、urlタイプに対応


Version 0.0		(2012-05-18)

 * html5form-1.5.jsを非同期ajaxを前提としない仕様に変更
 * エラーメッセージをコントロールごとのフキダシに表示
