# [mondaiユーザガイド](<?php href('docs'); ?>) / 出題

## 全体の流れ
mondaiの出題者は問題データの管理をGitHub上で行います。  
リポジトリ作成後は以下の手順の繰り返しとなります。

- ローカルリポジトリで問題データを更新。
- GitHubへpush。
- mondaiへpull。

Git、GitHubについては説明しません。

## 注意事項
- mondaiへ出題される問題は全てパブリックドメインになります。

clone、pull時にLICENSEをチェックしています。

- 文字エンコーディングはUTF-8またはSJIS-winを使用してください。

可能な限り文字エンコーディングUTF-8、改行コードLFを使用してください。

- 一度決めた問題IDと設問IDは変更しないでください。

全ての解答記録は問題IDと設問IDを元に記録されます。

## GitHubリポジトリの作成
- GitHubアカウントを取得しログインします。  
- <a target="_blank" href="https://github.com/kentasaito/mondai_data_example">kentasaito/mondai_data_example</a> でForkボタンをクリックします。  
- Settings > Repository name からリポジトリ名をmondai_dataへ変更します。  

(あなたのアカウント名)/mondai_data が表示されればリポジトリ作成は完了です。

## mondaiでのリポジトリ設定
- mondaiへログインします。  
- リポジトリ > 設定 へあなたのGitHubリポジトリを入力します。

あなたからの問題として、サンプル問題が表示されればリポジトリ設定は完了です。

## データ形式
index.csvは1行が1問題になります。  
2個のフィールドは、問題ID、問題名になります。

(問題名).csvは1行が1設問になります。  
3個のフィールドは、設問ID、問題分、解答になります。  
(問題名).csvはindex.csvで指定した任意のディレクトリに分類できます。

(問題名).csvと同じディレクトリに(問題名).(設問ID).[png|jpg|gif]を配置すると出題時に表示されます。

## 問題データの更新
- あなたのGitHubリポジトリをローカルへcloneします。 
 
Gitクライアントについては説明しません。お好きなものでどうぞ。

## 問題データの反映
- 更新をGitHubリポジトリへpushします。
- mondaiへログインします。  
- リポジトリ > 同期 でpullします。


更新されたあなたの問題が表示されれば問題データの反映は完了です。