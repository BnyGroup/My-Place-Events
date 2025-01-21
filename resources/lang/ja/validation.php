<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'その :attribute 受け入れられなければなりません。.',
    'active_url'           => 'その :attribute 無効なURLです',
    'after'                => 'その :attribute あとの日に違いありません :date.',
    'after_or_equal'       => 'その :attribute あとの日 or 同じに違いありません :date.',
    'alpha'                => 'その :attribute 文字が含まれるだけかも知れません',
    'alpha_dash'           => 'その :attribute 文字、数字、記号が含まれるだけかも知れません',
    'alpha_num'            => 'その :attribute 文字と数字が含まれるだけかも知れません',
    'array'                => 'その :attribute 配列に違いありません',
    'before'               => 'その :attribute のあとの日に違いありません :date.',
    'before_or_equal'      => 'その :attribute 前の日　or 同じ日に違いありません :date.',
    'between'              => [
        'numeric' => 'その :attribute 間に違いありません :min and :max.',
        'file'    => 'その :attribute 間に違いありません :min and :max kilobytes.',
        'string'  => 'その :attribute 間に違いありません :min and :max characters.',
        'array'   => 'その :attribute 間に違いありません :min and :max items.',
    ],
    'boolean'              => 'その :attribute field 違いありません true or false.',
    'confirmed'            => 'その :attribute 確認はマッチしません。',
    'date'                 => 'その :attribute 有効な日付ではありません',
    'date_format'          => 'その :attribute フォーマットがマッチしません :format.',
    'different'            => 'その :attribute and :other 異なるに違いない',
    'digits'               => 'その :attribute :digits 桁に違いない',
    'digits_between'       => 'その :attribute 間に違いない :min and :max digits.',
    'dimensions'           => 'その :attribute 有効なイメージがある　has invalid image dimensions.',
    'distinct'             => 'その :attribute フィールドは複製値を持つ',
    'email'                => 'その :attribute 有効なemailアドレスに違いない',
    'exists'               => 'その selected :attribute は無効である',
    'file'                 => 'その :attribute ファイルに違いない.',
    'filled'               => 'その :attribute フィールドは値を持つに違いない',
    'image'                => 'その :attribute イメージに違いない',
    'in'                   => 'その selected :attribute 無効である',
    'in_array'             => 'その :attribute フィールドは存在しない in :other.',
    'integer'              => 'その :attribute 整数に違いない',
    'ip'                   => 'その :attribute IP addressが有効に違いない',
    'ipv4'                 => 'その :attribute IPv4 addressが有効に違いない',
    'ipv6'                 => 'その :attribute IPv6 addressが有効に違いない',
    'json'                 => 'その :attribute 有効に違いない JSON string.',
    'max'                  => [
        'numeric' => 'その :attribute 以上でないかもれしない than :max.',
        'file'    => 'その :attribute 以上でないかもれしない :max kilobytes.',
        'string'  => 'その :attribute 以上でないかもれしない :max characters.',
        'array'   => 'その :attribute 以上ないかもれしない :max items.',
    ],
    'mimes'                => 'その :attribute ファイルの種類に違いない type: :values.',
    'mimetypes'            => 'その :attribute ファイルの種類に違いない type: :values.',
    'min'                  => [
        'numeric' => 'その :attribute 少なくとも〜に違いない :min.',
        'file'    => 'その :attribute 少なくとも〜に違いない :min kilobytes.',
        'string'  => 'その :attribute 少なくとも〜に違いない :min characters.',
        'array'   => 'その :attribute 少なくとも〜に違いない :min items.',
    ],
    'not_in'               => 'その selected :attribute is 無効です',
    'numeric'              => 'その :attribute 数字に違いない',
    'present'              => 'その :attribute field must be present.',
    'regex'                => 'その :attribute フィールドが無効です.',
    'required'             => 'その :attribute フィールドが要求される',
    'required_if'          => 'その :attribute フィールドが〜のとき要求される :other is :value.',
    'required_unless'      => 'その :attribute フィールドが〜でないとき要求される :other is in :values.',
    'required_with'        => 'その :attribute フィールドが〜のとき要求される :values is present.',
    'required_with_all'    => 'その :attribute フィールドが〜のとき要求される :values is present.',
    'required_without'     => 'その :attribute フィールドが〜のとき要求される :values is not present.',
    'required_without_all' => 'その :attribute フィールドが〜のとき要求される none of :values are present.',
    'same'                 => 'その :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'その :attribute 違いない :size.',
        'file'    => 'その :attribute 違いない :size kilobytes.',
        'string'  => 'その :attribute 違いない :size characters.',
        'array'   => 'その :attribute 含まれなければならない :size items.',
    ],
    'string'               => 'その :attribute 文字列に違いない',
    'timezone'             => 'その :attribute 有効なゾーンに違いない',
    'unique'               => 'その :attribute すでにTakenしている。',
    'uploaded'             => 'その :attribute アップロードに失敗した',
    'url'                  => 'その :attribute フォーマットは有効です.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'カスタムメッセージ',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    


    'attributes' => [
            'firstname'      => 'ファーストネーム',
            'email'  => '電子メール',
            'password'   => 'パスワード',
            'event_name'     => 'イベント名',
            'event_location'     => 'イベントの場所',
            'event_start_datetime'  => 'イベントの開始日',
            'event_end_datetime'    => 'イベントの終了日',
            'event_image'    => 'イベント画像',
            'event_description'     => 'イベントの説明',
            'event_address'  => 'イベントアドレス',
            'event_category'     => 'イベントカテゴリ',
            'event_org_name'     => '主催者名',
            'ticket_title'   => 'チケットのタイトル',
            'ticket_qty'     => 'チケット数',
            'ticket_price_actual'   => 'チケットの金額',

            /* organiser */
            'organizer_name'     => '主催者名',
            'profile_pics'   => '主催者イメージ',
            'about_organizer'    => '主催者について',

            /* user profile */
            'profile_pic'    => 'ユーザープロフィール画像',
            'lastname'   => '苗字',
            'new_password'   => '新しいパスワード',
            'repeat_new_password'   => 'パスワードを再度入力してください',
    ],


];
