<?php
/**
 * Internationalisation file for extension Renamewiki_user.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

$messages['en'] = array(
	'renamewiki_user'          => 'Rename wiki_user',
	'renamewiki_user-linkoncontribs' => 'rename wiki_user',
	'renamewiki_user-linkoncontribs-text' => 'Rename this wiki_user',
	'renamewiki_user-desc'     => 'Adds a [[Special:Renamewiki_user|special page]] to rename a wiki_user (need \'\'renamewiki_user\'\' right)',
	'renamewiki_user-summary' => '', # do not translate or duplicate this message to other languages
	'renamewiki_userold'       => 'Current wiki_username:',
	'renamewiki_usernew'       => 'New wiki_username:',
	'renamewiki_userreason'    => 'Reason for rename:',
	'renamewiki_usermove'      => 'Move wiki_user and talk pages (and their subpages) to new name',
	'renamewiki_usersuppress'  => 'Do not create redirects to the new name',
	'renamewiki_userreserve'   => 'Block the old wiki_username from future use',
	'renamewiki_userwarnings'  => 'Warnings:',
	'renamewiki_userconfirm'   => 'Yes, rename the wiki_user',
	'renamewiki_usersubmit'    => 'Submit',
	'renamewiki_user-submit-blocklog' => 'Show block log for wiki_user',

	'renamewiki_usererrordoesnotexist' => 'The wiki_user "<nowiki>$1</nowiki>" does not exist.',
	'renamewiki_usererrorexists'       => 'The wiki_user "<nowiki>$1</nowiki>" already exists.',
	'renamewiki_usererrorinvalid'      => 'The wiki_username "<nowiki>$1</nowiki>" is invalid.',
	'renamewiki_user-error-request'    => 'There was a problem with receiving the request.
Please go back and try again.',
	'renamewiki_user-error-same-wiki_user'  => 'You cannot rename a wiki_user to the same thing as before.',
	'renamewiki_usersuccess'           => 'The wiki_user "<nowiki>$1</nowiki>" has been renamed to "<nowiki>$2</nowiki>".',

	'renamewiki_user-page-exists'  => 'The page $1 already exists and cannot be automatically overwritten.',
	'renamewiki_user-page-moved'   => 'The page $1 has been moved to $2.',
	'renamewiki_user-page-unmoved' => 'The page $1 could not be moved to $2.',

	'renamewiki_userlogpage'     => 'wiki_user rename log',
	'renamewiki_userlogpagetext' => 'This is a log of changes to wiki_user names.',
	'renamewiki_userlogentry'    => 'renamed $1 to "$2"',
	'renamewiki_user-log'        => '{{PLURAL:$1|1 edit|$1 edits}}. Reason: $2',
	'renamewiki_user-move-log'   => 'Automatically moved page while renaming the wiki_user "[[wiki_user:$1|$1]]" to "[[wiki_user:$2|$2]]"',

	'action-renamewiki_user'     => 'rename wiki_users',
	'right-renamewiki_user'      => 'Rename wiki_users',

	'renamewiki_user-renamed-notice' => 'This wiki_user has been renamed.
The rename log is provided below for reference.', # Supports GENDER
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Jon Harald Søby
 * @author Meno25
 * @author Nemo bis
 * @author Nike
 * @author SPQRobin
 * @author Siebrand
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'renamewiki_user-linkoncontribs' => 'Link description used on Special:Contributions and Special:DeletedContributions. Only added if a wiki_user has rights to rename wiki_users.',
	'renamewiki_user-linkoncontribs-text' => 'Tooltip for {{msg-mw|renamewiki_user-linkoncontribs}}.',
	'renamewiki_user-desc' => '{{desc}}',
	'renamewiki_userreserve' => 'Option to block the old wiki_username (after it has been renamed) from being used again.',
	'renamewiki_userwarnings' => '{{Identical|Warning}}',
	'renamewiki_usersubmit' => '{{Identical|Submit}}',
	'renamewiki_user-submit-blocklog' => 'Button text. When clicked, the block log entries for a given wiki_user will be displayed.',
	'renamewiki_userlogpage' => '{{doc-logpage}}',
	'renamewiki_userlogentry' => 'Used in [[Special:Log/renamewiki_user]].
* Parameter $1 is the original wiki_username
* Parameter $2 is the new wiki_username',
	'action-renamewiki_user' => '{{Doc-action|renamewiki_user}}',
	'right-renamewiki_user' => '{{doc-right|renamewiki_user}}',
	'renamewiki_user-renamed-notice' => 'This message supports the use of GENDER with parameter $1.',
);

/** ꢱꣃꢬꢵꢯ꣄ꢡ꣄ꢬꢵ (ꢱꣃꢬꢵꢯ꣄ꢡ꣄ꢬꢵ)
 * @author MooRePrabu
 */
$messages['saz'] = array(
	'renamewiki_user' => 'ꢮꢮ꣄ꢬꢸꢥꢵꢬ꣄ ꢥꢵꢮ꣄ ꢪꢬ꣄ꢗꢶ',
	'renamewiki_usernew' => 'ꢥꣁꢮ꣄ꢮꣁ  ꢮꢮ꣄ꢬꢸꢥꢵꢬ꣄ ꢥꢵꢮ꣄',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 * @author SPQRobin
 * @author පසිඳු කාවින්ද
 */
$messages['af'] = array(
	'renamewiki_user' => 'Hernoem gebruiker',
	'renamewiki_user-linkoncontribs' => 'hernoem gebruiker',
	'renamewiki_user-linkoncontribs-text' => 'Hernoem hierdie gebruiker',
	'renamewiki_user-desc' => "Herdoop gebruikers (benodig ''renamewiki_user'' regte)",
	'renamewiki_userold' => 'Huidige gebruikersnaam:',
	'renamewiki_usernew' => 'Nuwe gebruikersnaam:',
	'renamewiki_userreason' => 'Rede vir hernoeming:',
	'renamewiki_usermove' => 'Hernoem gebruikers- en besprekingsbladsye (met subblaaie) na nuwe naam',
	'renamewiki_usersuppress' => 'Moenie skep aansture na die nuwe naam',
	'renamewiki_userreserve' => 'Voorkom dat die ou gebruiker in die toekoms weer gebruik kan word',
	'renamewiki_userwarnings' => 'Waarskuwings:',
	'renamewiki_userconfirm' => 'Ja, hernoem die gebruiker',
	'renamewiki_usersubmit' => 'Hernoem',
	'renamewiki_usererrordoesnotexist' => 'Die gebruiker "<nowiki>$1</nowiki>" bestaan nie',
	'renamewiki_usererrorexists' => 'Die gebruiker "<nowiki>$1</nowiki>" bestaan reeds',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" is \'n ongeldige gebruikernaam',
	'renamewiki_user-error-request' => "Daar was 'n probleem met die ontvangs van die versoek. Gaan asseblief terug en probeer weer.",
	'renamewiki_user-error-same-wiki_user' => 'U kan nie a gebruiker na dieselfde naam hernoem nie.',
	'renamewiki_usersuccess' => 'Die gebruiker "<nowiki>$1</nowiki>" is hernoem na "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Die bladsy $1 bestaan reeds en kan nie outomaties oorskryf word nie.',
	'renamewiki_user-page-moved' => 'Die bladsy $1 is na $2 geskuif.',
	'renamewiki_user-page-unmoved' => 'Die bladsy $1 kon nie na $2 geskuif word nie.',
	'renamewiki_userlogpage' => 'Logboek van gebruikershernoemings',
	'renamewiki_userlogpagetext' => 'Hieronder is gebruikersname wat gewysig is.',
	'renamewiki_userlogentry' => 'het $1 na "$2" hernoem',
	'renamewiki_user-log' => '{{PLURAL:$1|1 wysiging|$1 wysigings}}. Rede: $2',
	'renamewiki_user-move-log' => 'Bladsy is outomaties geskuif met die wysiging van die gebruiker "[[wiki_user:$1|$1]]" na "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'Hernoem gebruikers',
	'renamewiki_user-renamed-notice' => 'Hierdie gebruiker is hernoem.
Relevante inligting uit die logboek van gebruikersnaamwysigings word hier onder ter verwysing weergegee.',
);

/** Aragonese (aragonés)
 * @author Juanpabl
 * @author SMP
 */
$messages['an'] = array(
	'renamewiki_user' => 'Renombrar un usuario',
	'renamewiki_user-linkoncontribs' => "cambiar o nombre d'iste usuario",
	'renamewiki_user-linkoncontribs-text' => "Cambiar o nombre d'iste usuario",
	'renamewiki_user-desc' => "Renombrar un usuario (amenista os dreitos de ''renamewiki_user'')",
	'renamewiki_userold' => 'Nombre actual:',
	'renamewiki_usernew' => 'Nombre nuevo:',
	'renamewiki_userreason' => "Razón d'o cambeo de nombre:",
	'renamewiki_usermove' => "Tresladar as pachinas d'usuario y de descusión (y as suyas sozpachinas) ta o nuevo nombre",
	'renamewiki_usersuppress' => 'No creyar reendreceras ta o nuevo nombre',
	'renamewiki_userreserve' => "Bloqueyar l'antigo nombre d'usuario ta privar que torne a ser usau",
	'renamewiki_userwarnings' => 'Alvertencias:',
	'renamewiki_userconfirm' => "Sí, quiero cambiar o nombre de l'usuario",
	'renamewiki_usersubmit' => 'Ninviar',
	'renamewiki_usererrordoesnotexist' => 'L\'usuario "<nowiki>$1</nowiki>" no existe.',
	'renamewiki_usererrorexists' => 'L\'usuario "<nowiki>$1</nowiki>" ya existe.',
	'renamewiki_usererrorinvalid' => 'O nombre d\'usuario "<nowiki>$1</nowiki>" no ye conforme.',
	'renamewiki_user-error-request' => 'Bi habió bell problema recullindo a demanda. Por favor, torne enta zaga y prebe una atra vegada.',
	'renamewiki_user-error-same-wiki_user' => 'No puede renombrar un usuario con o mesmo nombre que ya teneba.',
	'renamewiki_usersuccess' => 'S\'ha renombrau l\'usuario "<nowiki>$1</nowiki>" como "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'A pachina $1 ya existe y no puede estar sustituyita automaticament.',
	'renamewiki_user-page-moved' => "S'ha tresladato a pachina $1 ta $2.",
	'renamewiki_user-page-unmoved' => "A pachina $1 no s'ha puesto tresladar ta $2.",
	'renamewiki_userlogpage' => "Rechistro de cambios de nombre d'usuarios",
	'renamewiki_userlogpagetext' => "Isto ye un rechistro de cambios de nombres d'usuarios",
	'renamewiki_userlogentry' => 'Renombrato $1 como "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 edición|$1 edicions}}. Razón: $2',
	'renamewiki_user-move-log' => 'Pachina tresladata automaticament en renombrar o usuario "[[wiki_user:$1|$1]]" como "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'Renombrar usuarios',
	'renamewiki_user-renamed-notice' => "O nombre d'iste usuario s'ha modificau.
O rechistro de cambeos de nombre d'usuario se proveye debaixo ta mas referencia.",
);

/** Old English (Ænglisc)
 * @author Spacebirdy
 */
$messages['ang'] = array(
	'renamewiki_user' => 'Ednemnan brūcend',
	'renamewiki_user-linkoncontribs' => 'ednemnan brūcend',
	'renamewiki_usersubmit' => 'Forþsendan',
);

/** Arabic (العربية)
 * @author Aiman titi
 * @author DRIHEM
 * @author Meno25
 * @author Mido
 * @author OsamaK
 */
$messages['ar'] = array(
	'renamewiki_user' => 'إعادة تسمية مستخدم',
	'renamewiki_user-linkoncontribs' => 'أعد تسمية المستخدم',
	'renamewiki_user-linkoncontribs-text' => 'أعد تسمية هذا المستخدم',
	'renamewiki_user-desc' => "يضيف [[Special:Renamewiki_user|صفحة خاصة]] لإعادة تسمية مستخدم (يحتاج إلى صلاحية ''renamewiki_user'')",
	'renamewiki_userold' => 'اسم المستخدم الحالي:',
	'renamewiki_usernew' => 'الاسم الجديد:',
	'renamewiki_userreason' => 'السبب لإعادة التسمية:',
	'renamewiki_usermove' => 'انقل صفحات المستخدم ونقاشه (بالصفحات الفرعية) إلى الاسم الجديد',
	'renamewiki_usersuppress' => 'لا تقم بإنشاء تحويلات إلى الاسم الجديد',
	'renamewiki_userreserve' => 'احفظ اسم المستخدم القديم ضد الاستخدام',
	'renamewiki_userwarnings' => 'التحذيرات:',
	'renamewiki_userconfirm' => 'نعم، أعد تسمية المستخدم',
	'renamewiki_usersubmit' => 'إرسال',
	'renamewiki_user-submit-blocklog' => 'أظهر سجل المنع الخاص بالمستخدم',
	'renamewiki_usererrordoesnotexist' => 'لا يوجد مستخدم بالاسم "<nowiki>$1</nowiki>"',
	'renamewiki_usererrorexists' => 'المستخدم "<nowiki>$1</nowiki>" موجود بالفعل',
	'renamewiki_usererrorinvalid' => 'اسم المستخدم "<nowiki>$1</nowiki>" غير صحيح',
	'renamewiki_user-error-request' => 'حدثت مشكلة أثناء استقبال الطلب.
من فضلك عد وحاول مرة ثانية.',
	'renamewiki_user-error-same-wiki_user' => 'لا يمكنك إعادة تسمية مستخدم بنفس الاسم كما كان من قبل.',
	'renamewiki_usersuccess' => 'تمت إعادة تسمية المستخدم "<nowiki>$1</nowiki>" إلى "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'الصفحة $1 موجودة بالفعل ولا يمكن إنشاء أخرى مكانها أوتوماتيكيا.',
	'renamewiki_user-page-moved' => 'تم نقل الصفحة $1 إلى $2.',
	'renamewiki_user-page-unmoved' => 'لم يتمكن من نقل الصفحة $1 إلى $2.',
	'renamewiki_userlogpage' => 'سجل إعادة تسمية المستخدمين',
	'renamewiki_userlogpagetext' => 'هذا سجل بالتغييرات في أسماء المستخدمين',
	'renamewiki_userlogentry' => 'أعاد تسمية $1 باسم "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1||تعديل واحد|تعديلان|$1 تعديلات|$1 تعديلًا|$1 تعديل}}. السبب: $2',
	'renamewiki_user-move-log' => 'نقل الصفحة تلقائيا خلال إعادة تسمية المستخدم من "[[wiki_user:$1|$1]]" إلى "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'إعادة تسمية المستخدمين',
	'right-renamewiki_user' => 'إعادة تسمية المستخدمين',
	'renamewiki_user-renamed-notice' => 'لقد تمت إعادة تسمية {{GENDER:$1|هذا المستخدم|هذه المستخدمة}}.
سجل إعادة التسمية معروض بالأسفل كمرجع:',
);

/** Aramaic (ܐܪܡܝܐ)
 * @author Basharh
 * @author Michaelovic
 */
$messages['arc'] = array(
	'renamewiki_user' => 'ܫܚܠܦ ܫܡܐ ܕܡܦܠܚܢܐ',
	'renamewiki_user-linkoncontribs' => 'ܫܚܠܦ ܫܡܐ ܕܡܦܠܚܢܐ',
	'renamewiki_user-linkoncontribs-text' => 'ܫܚܠܦ ܫܡܐ ܕܗܢܐ ܡܦܠܚܢܐ',
	'renamewiki_userold' => 'ܫܡܐ ܕܡܦܠܚܢܐ ܥܬܝܩܐ:',
	'renamewiki_usernew' => 'ܫܡܐ ܕܡܦܠܚܢܐ ܚܕܬܐ:',
	'renamewiki_userwarnings' => 'ܙܘܗܪ̈ܐ:',
	'renamewiki_userconfirm' => 'ܐܝܢ, ܫܚܠܦ ܫܡܐ ܕܡܦܠܚܢܐ',
	'renamewiki_usersubmit' => 'ܡܨܝܘܬܐ',
	'renamewiki_userlogentry' => 'ܬܢܐ ܠܫܘܡܗܐ $1 ܒܫܡ "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 ܫܘܚܠܦܐ|$1 ܫܘܚܠܦ̈ܐ}}. ܥܠܬܐ: $2',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Ghaly
 * @author Meno25
 * @author Ramsis II
 */
$messages['arz'] = array(
	'renamewiki_user' => 'تغيير تسمية يوزر',
	'renamewiki_user-desc' => "بيضيف [[Special:Renamewiki_user|صفحة مخصوصة]] علشان تغير اسم يوزر(محتاج صلاحية ''renamewiki_user'')",
	'renamewiki_userold' => 'اسم اليوزر الحالي:',
	'renamewiki_usernew' => 'اسم اليوزر الجديد:',
	'renamewiki_userreason' => 'السبب لإعادة التسميه:',
	'renamewiki_usermove' => 'انقل صفحات اليوزر و مناقشاته (بالصفحات الفرعية)للاسم الجديد.',
	'renamewiki_userreserve' => 'احفظ اسم اليوزر القديم ضد الاستخدام',
	'renamewiki_userwarnings' => 'التحذيرات:',
	'renamewiki_userconfirm' => 'ايوه،سمى اليوزر دا من تاني',
	'renamewiki_usersubmit' => 'تقديم',
	'renamewiki_usererrordoesnotexist' => 'اليوزر"<nowiki>$1</nowiki>" مالوش وجود.',
	'renamewiki_usererrorexists' => 'اليوزر "<nowiki>$1</nowiki>" موجود من قبل كدا.',
	'renamewiki_usererrorinvalid' => 'اسم اليوزر "<nowiki>$1</nowiki>"مش صحيح.',
	'renamewiki_user-error-request' => 'حصلت مشكلة فى استلام الطلب.
لو سمحت ارجع لورا و حاول تانى.',
	'renamewiki_user-error-same-wiki_user' => 'ما ينفعش تغير اسم اليوزر لنفس الاسم من تانى.',
	'renamewiki_usersuccess' => 'اليوزر "<nowiki>$1</nowiki>" اتغير اسمه لـ"<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'الصفحة $1 موجودة من قبل كدا و ماينفعش يتكتب عليها اوتوماتيكى.',
	'renamewiki_user-page-moved' => 'تم نقل الصفحه $1 ل $2.',
	'renamewiki_user-page-unmoved' => 'الصفحة $1 مانفعش تتنقل لـ$2.',
	'renamewiki_userlogpage' => 'سجل تغيير تسمية اليوزرز',
	'renamewiki_userlogpagetext' => 'دا سجل بالتغييرات فى أسامى اليوزرز',
	'renamewiki_userlogentry' => 'اتغيرت تسمية$1 لـ "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 تعديل|$1 تعديل}}. علشان: $2',
	'renamewiki_user-move-log' => 'الصفحة اتنقلت اوتوماتيكى لما اليوزر  "[[wiki_user:$1|$1]]" اتغير اسمه لـ "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'غير اسم اليوزرز',
);

/** Assamese (অসমীয়া)
 * @author Bishnu Saikia
 * @author Gitartha.bordoloi
 */
$messages['as'] = array(
	'renamewiki_user' => 'ব্যৱহাৰকাৰীৰ নাম সলাওক',
	'renamewiki_user-linkoncontribs' => 'ব্যৱহাৰীৰ নাম সলাওক',
	'renamewiki_user-linkoncontribs-text' => 'এই ব্যৱহাৰকাৰীৰ পুনৰ্নামাকৰণ কৰক',
	'renamewiki_user-desc' => "এজন ব্যৱহাৰকাৰীৰ পুনৰ্নামাকৰণ কৰিবলৈ এখন [[Special:Renamewiki_user|বিশেষ পৃষ্ঠা]] যোগ দিয়ে (''renamewiki_user'' অধিকাৰৰ প্ৰয়োজন)",
	'renamewiki_userold' => 'বৰ্তমানৰ সদস্যনাম:',
	'renamewiki_usernew' => 'নতুন সদস্যনাম:',
	'renamewiki_userreason' => 'পুনৰ্নামাকৰণৰ কাৰণ:',
	'renamewiki_usermove' => 'সদস্যপৃষ্ঠা আৰু আলোচনা পৃষ্ঠা (আৰু সেইবোৰৰ উপপৃষ্ঠা) নতুন নামলৈ স্থানান্তৰ কৰক',
	'renamewiki_usersuppress' => 'নতুন নামলৈ পুনৰ্নিৰ্দেশ সৃষ্টি কৰিব নালাগে',
	'renamewiki_userreserve' => 'ভৱিষ্যত ব্যৱহাৰৰ বাবে পুৰণা সদস্যনামটো বাৰণ কৰক',
	'renamewiki_userwarnings' => 'সাৱধানবাণী:',
	'renamewiki_userconfirm' => 'হয়, সদস্যজনৰ পুনৰ্নামাকৰণ কৰক',
	'renamewiki_usersubmit' => 'দাখিল কৰক',
	'renamewiki_user-submit-blocklog' => 'ব্যৱহাৰকাৰীৰ প্ৰতিবন্ধক অভিলেখ দেখুৱাওক',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" নামৰ কোনো সদস্য নাই।',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" নামৰ সদস্য ইতিমধ্যে আছেই।',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" সদস্যনামটো অবৈধ।',
	'renamewiki_user-error-request' => 'অনুৰোধ গ্ৰহণ কৰাত কিছু সমস্যা হৈছে।
অনুগ্ৰহ কৰি ঘূৰি গৈ পুনৰ চেষ্টা কৰক।',
	'renamewiki_user-error-same-wiki_user' => 'আপুনি এজন সদস্যক আগৰ নামটোলৈকে নামান্তৰ কৰিব নোৱাৰে।',
	'renamewiki_usersuccess' => '"<nowiki>$1</nowiki>" সদস্যজনক "<nowiki>$2</nowiki>"লৈ নামান্তৰিত কৰা হৈছে।',
	'renamewiki_user-page-exists' => '$1 পৃষ্ঠাখন ইতিমধ্যেই আছে আৰু তাৰ ওপৰত স্বয়ংক্ৰিয়ভাৱে লিখিব নোৱাৰি।',
	'renamewiki_user-page-moved' => "$1 পৃষ্ঠাখন $2-লৈ স্থানান্তৰ কৰা হ'ল।",
	'renamewiki_user-page-unmoved' => '$1 পৃষ্ঠাখন $2-লৈ স্থানান্তৰ কৰা সম্ভৱ নহয়।',
	'renamewiki_userlogpage' => "সদস্যৰ পুনৰ্নামাকৰণ ল'গ",
	'renamewiki_userlogpagetext' => 'সদস্যনামৰ পৰিৱৰ্তনসমূহৰ ল’গ',
	'renamewiki_userlogentry' => '$1ক "$2"লৈ পুনৰ্নামাকৰণ কৰা হ\'ল',
	'renamewiki_user-log' => '{{PLURAL:$1|1 সম্পাদনা|$1 সম্পাদনাসমূহ}}। কাৰণ: $2',
	'renamewiki_user-move-log' => 'সদস্য "[[wiki_user:$1|$1]]"ক "[[wiki_user:$2|$2]]"লৈ পুনৰ্নামাকৰণ কৰোঁতে স্বয়ংক্ৰিয়ভাৱে পৃষ্ঠা স্থানান্তৰ হ\'ল।',
	'action-renamewiki_user' => 'সদস্যৰ পুনৰ্নামাকৰণ কৰক',
	'right-renamewiki_user' => 'সদস্যৰ পুনৰ্নামাকৰণ কৰক',
	'renamewiki_user-renamed-notice' => "এই সদস্যজনৰ পুনৰ্নামাকৰণ কৰা হৈছে।
তথ্যসূত্ৰ হিচাপে পুনৰ্নামাকৰণ ল'গ তলত দিয়া হ'ল।",
);

/** Asturian (asturianu)
 * @author Esbardu
 * @author Xuacu
 */
$messages['ast'] = array(
	'renamewiki_user' => 'Renomar usuariu',
	'renamewiki_user-linkoncontribs' => 'renomar usuariu',
	'renamewiki_user-linkoncontribs-text' => 'Renomar esti usuariu',
	'renamewiki_user-desc' => "Renoma un usuariu (necesita'l permisu ''renamewiki_user'')",
	'renamewiki_userold' => "Nome d'usuariu actual:",
	'renamewiki_usernew' => "Nome d'usuariu nuevu:",
	'renamewiki_userreason' => 'Motivu del cambéu de nome:',
	'renamewiki_usermove' => "Treslladar les páxines d'usuariu y d'alderique (y toles subpáxines) al nome nuevu",
	'renamewiki_usersuppress' => 'Nun crear redireiciones al nome nuevu',
	'renamewiki_userreserve' => "Bloquiar el nome d'usuariu antiguu pa evitar usalu nun futuru",
	'renamewiki_userwarnings' => 'Avisos:',
	'renamewiki_userconfirm' => "Sí, renomar l'usuariu",
	'renamewiki_usersubmit' => 'Unviar',
	'renamewiki_user-submit-blocklog' => 'Amosar el rexistru de bloqueos del usuariu',
	'renamewiki_usererrordoesnotexist' => 'L\'usuariu "<nowiki>$1</nowiki>" nun esiste.',
	'renamewiki_usererrorexists' => 'L\'usuariu "<nowiki>$1</nowiki>" yá esiste.',
	'renamewiki_usererrorinvalid' => 'El nome d\'usuariu "<nowiki>$1</nowiki>" nun ye válidu.',
	'renamewiki_user-error-request' => 'Hebo un problema al recibir el pidimientu. Por favor vuelve atrás y inténtalo otra vuelta.',
	'renamewiki_user-error-same-wiki_user' => 'Nun pues renomar un usuariu al mesmu nome que tenía.',
	'renamewiki_usersuccess' => 'L\'usuariu "<nowiki>$1</nowiki>" foi renomáu como "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'La páxina $1 yá esiste y nun pue ser sobreescrita automáticamente.',
	'renamewiki_user-page-moved' => 'La páxina $1 treslladóse a $2.',
	'renamewiki_user-page-unmoved' => 'La páxina $1 nun pudo treslladase a $2.',
	'renamewiki_userlogpage' => "Rexistru de cambios de nome d'usuariu",
	'renamewiki_userlogpagetext' => "Esti ye un rexistru de los cambios de nomes d'usuariu",
	'renamewiki_userlogentry' => 'renomó a $1 como "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 edición|$1 ediciones}}. Motivu: $2',
	'renamewiki_user-move-log' => 'Treslladóse la páxina automáticamente al renomar al usuariu "[[wiki_user:$1|$1]]" como "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'renomar usuarios',
	'right-renamewiki_user' => 'Renomar usuarios',
	'renamewiki_user-renamed-notice' => "Se renomó esti usuariu.
El rexistru de renomaos s'ufre darréu pa referencia.",
);

/** Azerbaijani (azərbaycanca)
 * @author Cekli829
 * @author Vago
 * @author Vugar 1981
 * @author Wertuose
 */
$messages['az'] = array(
	'renamewiki_user' => 'İstifadəçi adını dəyiş',
	'renamewiki_user-linkoncontribs' => 'istifadəçi adını dəyiş',
	'renamewiki_user-linkoncontribs-text' => 'Bu istifadəçinin adını dəyiş',
	'renamewiki_usernew' => 'Yeni istifadəçi adı:',
	'renamewiki_userwarnings' => 'Xəbərdarlıqlar:',
	'renamewiki_userconfirm' => 'Bəli, istifadəçinin adını dəyiş',
	'renamewiki_usersubmit' => 'Təsdiq et',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" istifadəçi adı mövcud deyil.',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" istifadəçi adı artıq mövcuddur.',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" istifadəçi adı yolverilməzdir.',
	'renamewiki_user-page-moved' => '$1 $2 səhifəsinə köçürülüb.',
	'renamewiki_user-page-unmoved' => '$1 $2 səhifəsinə köçürülə bilinmir.',
	'renamewiki_userlogpage' => 'İstifadəçi adı dəyişmə gündəliyi',
	'right-renamewiki_user' => 'istifadəçilərin adını dəyiş',
);

/** Bashkir (башҡортса)
 * @author Assele
 * @author ҒатаУлла
 */
$messages['ba'] = array(
	'renamewiki_user' => 'Ҡатнашыусының исемен үҙгәртергә',
	'renamewiki_user-linkoncontribs' => 'ҡатнашыусының исемен үҙгәртергә',
	'renamewiki_user-linkoncontribs-text' => 'Был ҡатнашыусының исемен үҙгәртергә',
	'renamewiki_user-desc' => "Ҡатнашыусы исемен үҙгәртеү өсөн [[Special:Renamewiki_user|махсус бит]] өҫтәй (''renamewiki_user'' хоҡуғы кәрәк)",
	'renamewiki_userold' => 'Хәҙерге исеме:',
	'renamewiki_usernew' => 'Яңы исеме:',
	'renamewiki_userreason' => 'Исемен үҙгәртеү сәбәбе:',
	'renamewiki_usermove' => 'Шулай уҡ ҡатнашыусы битенең, фекер алышыу битенең (һәм уларҙың эске биттәренең) исемен үҙгәртергә',
	'renamewiki_usersuppress' => 'Яңы исемгә йүнәлтеүҙәр булдырмаҫҡа',
	'renamewiki_userreserve' => 'Ҡатнашыусының элекке исемен киләсәктә ҡулланыу өсөн һаҡларға',
	'renamewiki_userwarnings' => 'Киҫәтеүҙәр:',
	'renamewiki_userconfirm' => 'Эйе, ҡатнашыусының исемен үҙгәртергә',
	'renamewiki_usersubmit' => 'Һаҡларға',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" исемле ҡатнашыусы теркәлмәгән.',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" исемле ҡатнашыусы теркәлгән инде.',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" ҡатнашыусы исеме дөрөҫ түгел.',
	'renamewiki_user-error-request' => 'Һорауҙы алыу менән ҡыйынлыҡтар тыуҙы.
Зинһар, кире ҡайтығыҙ һәм яңынан ҡабатлап ҡарағыҙ.',
	'renamewiki_user-error-same-wiki_user' => 'Һеҙ ҡатнашыусы исемен шул уҡ исемгә үҙгәртә алмайһығыҙ.',
	'renamewiki_usersuccess' => '"<nowiki>$1</nowiki>" ҡатнашыусыһының исеме "<nowiki>$2</nowiki>" исеменә үҙгәртелде.',
	'renamewiki_user-page-exists' => '$1 бите бар инде һәм уның өҫтөнә автоматик рәүештә яҙҙырыу мөмкин түгел.',
	'renamewiki_user-page-moved' => '$1 битенең исеме $2 тип үҙгәртелде.',
	'renamewiki_user-page-unmoved' => '$1 битенең исеме $2 тип үҙгәртелә алмай.',
	'renamewiki_userlogpage' => 'Ҡатнашыусы исемдәрен үҙгәртеү яҙмалары журналы',
	'renamewiki_userlogpagetext' => 'Был — ҡатнашыусы исемдәрен үҙгәртеү яҙмалары журналы.',
	'renamewiki_userlogentry' => '$1 ҡатнашыусыһын "$2" тип үҙгәрткән',
	'renamewiki_user-log' => '$1 {{PLURAL:$1|үҙгәртеү}}. Сәбәбе: $2',
	'renamewiki_user-move-log' => 'Биттең исеме "[[wiki_user:$1|$1]]" ҡатнашыусыһының исемен "[[wiki_user:$2|$2]]" тип үҙгәртеү сәбәпле үҙенән-үҙе үҙгәргән',
	'action-renamewiki_user' => 'Ҡатнашыусыларҙың исемен үҙгәртеү',
	'right-renamewiki_user' => 'Ҡатнашыусыларҙың исемен үҙгәртеү',
	'renamewiki_user-renamed-notice' => 'Был ҡатнашыусының исеме үҙгәртелгән.
Түбәндә белешмә өсөн исем үҙгәртеү яҙмалары журналы килтерелгән.',
);

/** Southern Balochi (بلوچی مکرانی)
 * @author Mostafadaneshvar
 */
$messages['bcc'] = array(
	'renamewiki_user' => 'کاربر نامی بدل کن',
	'renamewiki_user-desc' => "یک کاربر نامی بدیل کن(حق ''بدل نام''لازمن)",
	'renamewiki_userold' => 'هنوکین نام کاربری:',
	'renamewiki_usernew' => 'نوکین نام کاربری:',
	'renamewiki_userreason' => 'دلیل په نام بدل کتن:',
	'renamewiki_usermove' => 'صفحات گپ و کاربر (و آیانی زیر صفحات) په نوکین نام جاه په جاه کن',
	'renamewiki_userwarnings' => 'هوژاریان:',
	'renamewiki_userconfirm' => 'بله، کاربر نامی عوض کن',
	'renamewiki_usersubmit' => 'دیم دی',
	'renamewiki_usererrordoesnotexist' => 'کاربر "<nowiki>$1</nowiki>" موجود نهنت.',
	'renamewiki_usererrorexists' => 'کاربر "<nowiki>$1</nowiki>" هنو هستن.',
	'renamewiki_usererrorinvalid' => 'نام کاربری "<nowiki>$1</nowiki>"  نامعتبر انت.',
	'renamewiki_user-error-request' => 'مشکلی گون دریافت درخواست هستت.
لطفا برگردیت و دگه تلاش کنیت.',
	'renamewiki_user-error-same-wiki_user' => 'شما نه تونیت یک کاربر په هما پیشگین چیزی نامی بدل کنیت',
	'renamewiki_usersuccess' => 'کاربر "<nowiki>$1</nowiki>" نامی بدل بوتت په "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'صفحه $1 الان هست و اتوماتیکی اور آی نوسیگ نه بیت.',
	'renamewiki_user-page-moved' => 'صفحه $1 جاه په جاه بیت په $2.',
	'renamewiki_user-page-unmoved' => 'صفحه $1 نه تونیت په $2 جاه په جاه بیت.',
	'renamewiki_userlogpage' => 'آمار نام بدل کتن کاربر',
	'renamewiki_userlogpagetext' => 'شی آماری چه تغییرات نامان کاربران انت',
	'renamewiki_userlogentry' => 'نام بدل بوت  $1 په "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 اصلاح|$1 اصلاحلات}}. دلیل: $2',
	'renamewiki_user-move-log' => 'اتوماتیکی صفحه جاه په جاه بیت وهدی که کاربر نام بدل بی "[[wiki_user:$1|$1]]" به "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'عوض کتن نام کابران',
);

/** Bikol Central (Bikol Central)
 * @author Filipinayzd
 */
$messages['bcl'] = array(
	'renamewiki_usersubmit' => 'Isumitir',
	'renamewiki_usererrordoesnotexist' => 'An parágamit "<nowiki>$1</nowiki>" mayò man',
	'renamewiki_usererrorexists' => 'An parágamit "<nowiki>$1</nowiki>" yaon na',
	'renamewiki_user-page-moved' => 'An páhinang $1 piglipat sa $2.',
	'renamewiki_user-page-unmoved' => 'An páhinang $1 dai mailipat sa $2.',
	'renamewiki_user-log' => '$1 mga hirá. Rasón: $2',
);

/** Belarusian (Taraškievica orthography) (беларуская (тарашкевіца)‎)
 * @author EugeneZelenko
 * @author Jim-by
 * @author Red Winged Duck
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'renamewiki_user' => 'Перайменаваць рахунак удзельніка',
	'renamewiki_user-linkoncontribs' => 'перайменаваць удзельніка',
	'renamewiki_user-linkoncontribs-text' => 'Перайменаваць рахунак гэтага ўдзельніка',
	'renamewiki_user-desc' => "Дадае [[Special:Renamewiki_user|спэцыяльную старонку]] для перайменаваньня рахунку ўдзельніка (неабходныя правы на ''перайменаваньне ўдзельніка'')",
	'renamewiki_userold' => 'Цяперашняе імя ўдзельніка:',
	'renamewiki_usernew' => 'Новае імя:',
	'renamewiki_userreason' => 'Прычына перайменаваньня:',
	'renamewiki_usermove' => 'Перайменаваць старонкі ўдзельніка і гутарак (і іх падстаронкі)',
	'renamewiki_usersuppress' => 'Не ствараць перанакіраваньні на новую назву рахунку',
	'renamewiki_userreserve' => 'Заблякаваць старое імя ўдзельніка для выкарыстаньня ў будучыні',
	'renamewiki_userwarnings' => 'Папярэджаньні:',
	'renamewiki_userconfirm' => 'Так, перайменаваць удзельніка',
	'renamewiki_usersubmit' => 'Перайменаваць',
	'renamewiki_user-submit-blocklog' => 'Паказаць журнал блякаваньняў удзельніка',
	'renamewiki_usererrordoesnotexist' => 'Рахунак «<nowiki>$1</nowiki>» не існуе.',
	'renamewiki_usererrorexists' => 'Рахунак «<nowiki>$1</nowiki>» ужо існуе.',
	'renamewiki_usererrorinvalid' => 'Няслушнае імя ўдзельніка «<nowiki>$1</nowiki>».',
	'renamewiki_user-error-request' => 'Узьніклі праблемы з атрыманьнем запыту.
Калі ласка, вярніцеся назад і паспрабуйце ізноў.',
	'renamewiki_user-error-same-wiki_user' => 'Немагчыма перайменаваць рахунак удзельніка ў тое ж самае імя.',
	'renamewiki_usersuccess' => 'Рахунак «<nowiki>$1</nowiki>» быў перайменаваны ў «<nowiki>$2</nowiki>».',
	'renamewiki_user-page-exists' => 'Старонка $1 ужо існуе і ня можа быць аўтаматычна перазапісаная.',
	'renamewiki_user-page-moved' => 'Старонка $1 была перайменаваная ў $2.',
	'renamewiki_user-page-unmoved' => 'Старонка $1 ня можа быць перайменаваная ў $2.',
	'renamewiki_userlogpage' => 'Журнал перайменаваньняў удзельнікаў',
	'renamewiki_userlogpagetext' => 'Гэта журнал перайменаваньняў рахункаў удзельнікаў.',
	'renamewiki_userlogentry' => 'перайменаваў $1 у «$2»',
	'renamewiki_user-log' => '$1 {{PLURAL:$1|рэдагаваньне|рэдагаваньні|рэдагаваньняў}}. Прычына: $2',
	'renamewiki_user-move-log' => 'Аўтаматычнае перайменаваньне старонкі ў сувязі зь перайменаваньнем рахунку ўдзельніка з «[[wiki_user:$1|$1]]» у «[[wiki_user:$2|$2]]»',
	'action-renamewiki_user' => 'пераймяноўваць удзельнікаў',
	'right-renamewiki_user' => 'перайменаваньне ўдзельнікаў',
	'renamewiki_user-renamed-notice' => '{{GENDER:$1|Гэты удзельнік быў перайменаваны|Гэтая удзельніца была перайменаваная}}.
Журнал перайменаваньняў удзельнікаў пададзены ніжэй для даведкі.',
);

/** Bulgarian (български)
 * @author Borislav
 * @author DCLXVI
 * @author Spiritia
 * @author Turin
 */
$messages['bg'] = array(
	'renamewiki_user' => 'Преименуване на потребител',
	'renamewiki_user-linkoncontribs' => 'преименуване на потребител',
	'renamewiki_user-linkoncontribs-text' => 'Преименуване на този потребител',
	'renamewiki_user-desc' => 'Добавя възможност за преименуване на потребители',
	'renamewiki_userold' => 'Текущо потребителско име:',
	'renamewiki_usernew' => 'Ново потребителско име:',
	'renamewiki_userreason' => 'Причина за преименуването:',
	'renamewiki_usermove' => 'Преместване под новото име на потребителската лична страница и беседа (както и техните подстраници)',
	'renamewiki_usersuppress' => 'Без създаване на пренасочване към новото име',
	'renamewiki_userreserve' => 'Блокиране на старото потребителско име срещу узурпация в бъдеще',
	'renamewiki_userwarnings' => 'Предупреждения:',
	'renamewiki_userconfirm' => 'Да, преименуване на потребителя',
	'renamewiki_usersubmit' => 'Изпълнение',
	'renamewiki_usererrordoesnotexist' => 'Потребителят „<nowiki>$1</nowiki>“ не съществува.',
	'renamewiki_usererrorexists' => 'Потребителят „<nowiki>$1</nowiki>“ вече съществува.',
	'renamewiki_usererrorinvalid' => 'Потребителското име „<nowiki>$1</nowiki>“ е невалидно.',
	'renamewiki_user-error-request' => 'Имаше проблем с приемането на заявката. Върнете се на предишната страница и опитайте отново!',
	'renamewiki_user-error-same-wiki_user' => 'Новото потребителско име е същото като старото.',
	'renamewiki_usersuccess' => 'Потребителят „<nowiki>$1</nowiki>“ беше преименуван на „<nowiki>$2</nowiki>“',
	'renamewiki_user-page-exists' => 'Страницата $1 вече съществува и не може да бъде автоматично заместена.',
	'renamewiki_user-page-moved' => 'Страницата $1 беше преместена като $2.',
	'renamewiki_user-page-unmoved' => 'Страницата $1 не можа да бъде преместена като $2.',
	'renamewiki_userlogpage' => 'Дневник на преименуванията',
	'renamewiki_userlogpagetext' => 'В този дневник се записват преименуванията на потребители.',
	'renamewiki_userlogentry' => 'преименува $1 на „$2“',
	'renamewiki_user-log' => '{{PLURAL:$1|една редакция|$1 редакции}}. Причина: $2',
	'renamewiki_user-move-log' => 'Автоматично преместена страница при преименуването на потребител "[[wiki_user:$1|$1]]" като "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'преименуване на потребители',
	'renamewiki_user-renamed-notice' => 'Потребителят беше преименуван.
За справка по-долу е показан Дневникът на преименуванията.',
);

/** Bengali (বাংলা)
 * @author Bellayet
 * @author Nasir8891
 */
$messages['bn'] = array(
	'renamewiki_user' => 'ব্যবহারকারী নামান্তর করো',
	'renamewiki_user-linkoncontribs' => 'ব্যবহারকারী নামান্তর',
	'renamewiki_user-linkoncontribs-text' => 'এই ব্যবহারকারী নামান্তর করো',
	'renamewiki_user-desc' => "একজন ব্যবহারকারীকে নামান্তর করুন (''ব্যবহাকারী নামান্তর'' অধিকার প্রয়োজন)",
	'renamewiki_userold' => 'বর্তমান ব্যবহারকারী নাম:',
	'renamewiki_usernew' => 'নতুন ব্যবহারকারী নাম:',
	'renamewiki_userreason' => 'নামান্তরের কারণ:',
	'renamewiki_usermove' => 'ব্যবহারকারী এবং আলাপের পাতা (এবং তার উপপাতাসমূহ) নতুন নামে সরিয়ে নাও',
	'renamewiki_usersuppress' => 'নতুন নামে রিডাইরেক্ট করবেন না',
	'renamewiki_userreserve' => 'ভবিষ্যতে উদ্দেশ্যে পুরাতন ব্যবহারকারী নাম ব্লক করা হল',
	'renamewiki_userwarnings' => 'সতর্কীকরণ:',
	'renamewiki_userconfirm' => 'হ্যাঁ, ব্যবহারকারীর নাম পরিবর্তন করো',
	'renamewiki_usersubmit' => 'জমা দাও',
	'renamewiki_user-submit-blocklog' => 'ব্যবহারকারীর ব্লক লগ দেখুন',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" নামের কোন ব্যবহারকারী নাই।',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" ব্যবহারকারী ইতিমধ্যে বিদ্যমান আছে।',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" ব্যবহারকারী নামটি ঠিক নয়।',
	'renamewiki_user-error-request' => 'এই অনুরোধ গ্রহণে সমস্যা ছিল। দয়াকরে পেছনে যান এবং আবার চেষ্টা করুন।',
	'renamewiki_user-error-same-wiki_user' => 'আপনি পূর্বের নামে নামান্তর করতে পারবেন না।',
	'renamewiki_usersuccess' => 'ব্যবহারকারী "<nowiki>$1</nowiki>" থেকে "<nowiki>$2</nowiki>" তে নামান্তরিত করা হয়েছে।',
	'renamewiki_user-page-exists' => 'পাতা $1 বিদ্যমান এবং সয়ঙ্ক্রিয়ভাবে এটির উপর লেখা যাবে না',
	'renamewiki_user-page-moved' => 'পাতাটি $1 থেকে $2 তে সরিয়ে নেওয়া হয়েছে।',
	'renamewiki_user-page-unmoved' => 'পাতাটি $1 থেকে $2 তে সরিয়ে নেওয়া যাবে না।',
	'renamewiki_userlogpage' => 'ব্যবহারকারী নামান্তরের লগ',
	'renamewiki_userlogpagetext' => 'এটি ব্যাবহারকারী নামের পরিবর্তনের লগ',
	'renamewiki_userlogentry' => '$1 থেকে "$2" তে নামান্তর করা হয়েছে',
	'renamewiki_user-log' => '{{PLURAL:$1|1 সম্পাদনা|$1 সম্পাদনাসমূহ}}। কারণ: $2',
	'renamewiki_user-move-log' => 'যখন ব্যবহারকারী "[[wiki_user:$1|$1]]" থেকে "[[wiki_user:$2|$2]]" তে নামান্তরিত হবে তখন সয়ঙ্ক্রিয়ভাবে পাতা সরিয়ে নেওয়া হয়েছে',
	'action-renamewiki_user' => 'ব্যবহারকারী নাম পরিবর্তন',
	'right-renamewiki_user' => 'ব্যবহারকারীদের পুনরায় নাম দাও',
	'renamewiki_user-renamed-notice' => 'এই ব্যবহারকারীর নাম পরিবর্তন করা হয়েছে।
সূত্র হিসাবে নিচে নাম পরিবর্তন লগ দেওয়া হল।',
);

/** Breton (brezhoneg)
 * @author Fulup
 * @author Gwendal
 * @author Y-M D
 */
$messages['br'] = array(
	'renamewiki_user' => 'Adenvel an implijer',
	'renamewiki_user-linkoncontribs' => 'adenvel an implijer',
	'renamewiki_user-linkoncontribs-text' => 'adenvel an implijer-mañ',
	'renamewiki_user-desc' => "Adenvel un implijer (ret eo kaout ''gwirioù adenvel'')",
	'renamewiki_userold' => 'Anv a-vremañ an implijer :',
	'renamewiki_usernew' => 'Anv implijer nevez :',
	'renamewiki_userreason' => 'Abeg evit adenvel :',
	'renamewiki_usermove' => 'Kas ar pajennoù implijer ha kaozeal (hag o ispajennoù) betek o anv nevez',
	'renamewiki_usersuppress' => 'Arabat krouiñ adkasoù war-du an anv nevez',
	'renamewiki_userreserve' => "Mirout na vo implijet an anv kozh pelloc'h en dazont",
	'renamewiki_userwarnings' => 'Diwallit :',
	'renamewiki_userconfirm' => 'Ya, adenvel an implijer',
	'renamewiki_usersubmit' => 'Kas',
	'renamewiki_user-submit-blocklog' => 'Diskwel marilh stankañ an implijer',
	'renamewiki_usererrordoesnotexist' => 'An implijer "<nowiki>$1</nowiki>" n\'eus ket anezhañ',
	'renamewiki_usererrorexists' => 'Krouet eo bet an anv implijer "<nowiki>$1</nowiki>" dija',
	'renamewiki_usererrorinvalid' => 'Faziek eo an anv implijer "<nowiki>$1</nowiki>"',
	'renamewiki_user-error-request' => 'Ur gudenn zo bet gant degemer ar reked. Kit war-gil ha klaskit en-dro.',
	'renamewiki_user-error-same-wiki_user' => "N'haller ket adenvel un implijer gant an hevelep anv hag a-raok.",
	'renamewiki_usersuccess' => 'Deuet eo an implijer "<nowiki>$1</nowiki>" da vezañ "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => "Bez' ez eus eus ar bajenn $1 dija, n'haller ket hec'h erlec'hiañ ent emgefreek.",
	'renamewiki_user-page-moved' => 'Adkaset eo bet ar bajenn $1 da $2.',
	'renamewiki_user-page-unmoved' => "N'eus ket bet gallet adkas ar bajenn $1 da $2.",
	'renamewiki_userlogpage' => 'Roll an implijerien bet adanvet',
	'renamewiki_userlogpagetext' => 'Setu istor an implijerien bet cheñchet o anv ganto',
	'renamewiki_userlogentry' => 'en deus adanvet $1 e "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 degasadenn|$1 degasadenn}}. Abeg : $2',
	'renamewiki_user-move-log' => 'Pajenn dilec\'hiet ent emgefreek e-ser adenvel an implijer "[[wiki_user:$1|$1]]" e "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'Adenvel implijerien',
	'right-renamewiki_user' => 'Adenvel implijerien',
	'renamewiki_user-renamed-notice' => "Adanvet eo bet an implijer-mañ.
A-is emañ marilh an adanvadurioù, ma'z oc'h dedennet.",
);

/** Bosnian (bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'renamewiki_user' => 'Preimenuj korisnika',
	'renamewiki_user-linkoncontribs' => 'preimenuj korisnika',
	'renamewiki_user-linkoncontribs-text' => 'Preimenuj ovog korisnika',
	'renamewiki_user-desc' => "Dodaje [[Special:Renamewiki_user|posebnu stranicu]] u svrhu promjene imena korisnika (zahtjeva pravo ''preimenovanja korisnika'')",
	'renamewiki_userold' => 'Trenutno ime korisnika:',
	'renamewiki_usernew' => 'Novo korisničko ime:',
	'renamewiki_userreason' => 'Razlog promjene imena:',
	'renamewiki_usermove' => 'Premještanje korisnika i njegove stranice za razgovor (zajedno sa podstranicama) na novo ime',
	'renamewiki_usersuppress' => 'Ne pravi preusmjerenja na novo ime',
	'renamewiki_userreserve' => 'Blokiraj staro korisničko ime od kasnijeg korištenja',
	'renamewiki_userwarnings' => 'Upozorenja:',
	'renamewiki_userconfirm' => 'Da, promijeni ime korisnika',
	'renamewiki_usersubmit' => 'Pošalji',
	'renamewiki_usererrordoesnotexist' => 'Korisnik "<nowiki>$1</nowiki>" ne postoji.',
	'renamewiki_usererrorexists' => 'Korisnik "<nowiki>$1</nowiki>" već postoji.',
	'renamewiki_usererrorinvalid' => 'Korisničko ime "<nowiki>$1</nowiki>" nije valjano.',
	'renamewiki_user-error-request' => 'Nastao je problem pri prijemu zahtjeva.
Molimo Vas da se vratite nazad i pokušate ponovo.',
	'renamewiki_user-error-same-wiki_user' => 'Ne može se promijeniti ime korisnika u isto kao i ranije.',
	'renamewiki_usersuccess' => 'Ime korisnika "<nowiki>$1</nowiki>" je promijenjeno u "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Stranica $1 već postoji i ne može biti automatski prepisana.',
	'renamewiki_user-page-moved' => 'Stranica $1 je premještena na $2.',
	'renamewiki_user-page-unmoved' => 'Stranica $1 nije mogla biti premještena na $2.',
	'renamewiki_userlogpage' => 'Zapisnik preimenovanja korisnika',
	'renamewiki_userlogpagetext' => 'Ovo je zapisnik promjena korisničkih imena.',
	'renamewiki_userlogentry' => '$1 preimenovan u "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 izmjena|$1 izmjene|$1 izmjena}}. Razlog: $2',
	'renamewiki_user-move-log' => 'Automatski premještena stranica pri promjeni korisničkog imena "[[wiki_user:$1|$1]]" u "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'Preimenovanje korisnika',
	'renamewiki_user-renamed-notice' => 'Ovaj korisnik je promijenio ime.
Zapisnik preimenovanje je prikazan ispod kao referenca.',
);

/** Catalan (català)
 * @author Arnaugir
 * @author El libre
 * @author Juanpabl
 * @author Paucabot
 * @author Qllach
 * @author SMP
 * @author Toniher
 * @author Vriullop
 */
$messages['ca'] = array(
	'renamewiki_user' => "Reanomena l'usuari",
	'renamewiki_user-linkoncontribs' => "Reanomena l'usuari/a",
	'renamewiki_user-linkoncontribs-text' => "Canvia el nom d'aquest usuari/a",
	'renamewiki_user-desc' => "Reanomena un usuari (necessita drets de ''renamewiki_user'')",
	'renamewiki_userold' => "Nom d'usuari actual:",
	'renamewiki_usernew' => "Nou nom d'usuari:",
	'renamewiki_userreason' => 'Motiu pel canvi:',
	'renamewiki_usermove' => "Reanomena la pàgina d'usuari, la de discussió i les subpàgines que tingui al nou nom",
	'renamewiki_usersuppress' => 'No creis redireccions cap al nou nom',
	'renamewiki_userreserve' => "Bloca el nom d'usuari antic d'usos futurs",
	'renamewiki_userwarnings' => 'Advertències:',
	'renamewiki_userconfirm' => "Sí, reanomena l'usuari",
	'renamewiki_usersubmit' => 'Tramet',
	'renamewiki_user-submit-blocklog' => "Mostra el registre de bloquejos per l'usuari",
	'renamewiki_usererrordoesnotexist' => "L'usuari «<nowiki>$1</nowiki>» no existeix",
	'renamewiki_usererrorexists' => "L'usuari «<nowiki>$1</nowiki>» ja existeix",
	'renamewiki_usererrorinvalid' => "El nom d'usuari «<nowiki>$1</nowiki>» no és vàlid",
	'renamewiki_user-error-request' => "Hi ha hagut un problema en la recepció de l'ordre.
Torneu enrere i torneu-ho a intentar.",
	'renamewiki_user-error-same-wiki_user' => 'No podeu reanomenar un usuari a un nom que ja tenia anteriorment.',
	'renamewiki_usersuccess' => "L'usuari «<nowiki>$1</nowiki>» s'ha reanomenat com a «<nowiki>$2</nowiki>»",
	'renamewiki_user-page-exists' => 'La pàgina «$1» ja existeix i no pot ser sobreescrita automàticament',
	'renamewiki_user-page-moved' => "La pàgina «$1» s'ha reanomenat com a «$2».",
	'renamewiki_user-page-unmoved' => "La pàgina $1 no s'ha pogut reanomenar com a «$2».",
	'renamewiki_userlogpage' => "Registre del canvi de nom d'usuari",
	'renamewiki_userlogpagetext' => "Aquest és un registre dels canvis als noms d'usuari",
	'renamewiki_userlogentry' => 'ha reanomenat $1 a "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|Una contribució|$1 contribucions}}. Motiu: $2',
	'renamewiki_user-move-log' => "S'ha reanomenat automàticament la pàgina mentre es reanomenava l'usuari «[[wiki_user:$1|$1]]» com «[[wiki_user:$2|$2]]»",
	'action-renamewiki_user' => 'reanomena usuaris',
	'right-renamewiki_user' => 'Reanomenar usuaris',
	'renamewiki_user-renamed-notice' => "S'ha canviat el nom d'aquest usuari.
A continuació es proporciona el registre de reanomenaments per a més informació.",
);

/** Chechen (нохчийн)
 * @author Sasan700
 */
$messages['ce'] = array(
	'renamewiki_user' => 'Декъашхон цlе хийца',
	'renamewiki_user-linkoncontribs' => 'декъашхон цlе хийца',
);

/** Sorani Kurdish (کوردی) */
$messages['ckb'] = array(
	'renamewiki_usersubmit' => 'ناردن',
);

/** Crimean Turkish (Latin script) (qırımtatarca (Latin)‎)
 * @author Don Alessandro
 */
$messages['crh-latn'] = array(
	'renamewiki_userlogpage' => 'Qullanıcı adı deñişikligi jurnalı',
	'renamewiki_userlogpagetext' => 'Aşağıda bulunğan cedvel adı deñiştirilgen qullanıcılarnı köstere',
	'renamewiki_userlogentry' => '$1 qullanıcısınıñ adını "$2" оlaraq deñiştirdi',
	'renamewiki_user-log' => '{{PLURAL:$1|1 deñişiklik|$1 deñişiklik}} yapqan. Sebep: $2',
);

/** Crimean Turkish (Cyrillic script) (къырымтатарджа (Кирилл)‎)
 * @author Don Alessandro
 */
$messages['crh-cyrl'] = array(
	'renamewiki_userlogpage' => 'Къулланыджы ады денъишиклиги журналы',
	'renamewiki_userlogpagetext' => 'Ашагъыда булунгъан джедвель ады денъиштирильген къулланыджыларны косьтере',
	'renamewiki_userlogentry' => '$1 къулланыджысынынъ адыны "$2" оларакъ денъиштирди',
	'renamewiki_user-log' => '{{PLURAL:$1|1 денъишиклик|$1 денъишиклик}} япкъан. Себеп: $2',
);

/** Czech (česky)
 * @author Danny B.
 * @author Li-sung
 * @author Martin Kozák
 * @author Matěj Grabovský
 * @author Mormegil
 */
$messages['cs'] = array(
	'renamewiki_user' => 'Přejmenovat uživatele',
	'renamewiki_user-linkoncontribs' => 'přejmenovat uživatele',
	'renamewiki_user-linkoncontribs-text' => 'Přejmenovat tohoto uživatele',
	'renamewiki_user-desc' => "Přejmenování uživatele (vyžadováno oprávnění ''renamewiki_user'')",
	'renamewiki_userold' => 'Stávající uživatelské jméno:',
	'renamewiki_usernew' => 'Nové uživatelské jméno:',
	'renamewiki_userreason' => 'Důvod přejmenování:',
	'renamewiki_usermove' => 'Přesunout uživatelské a diskusní stránky (a jejich podstránky) na nové jméno',
	'renamewiki_usersuppress' => 'Nevytvářet přesměrování na nové jméno',
	'renamewiki_userreserve' => 'Zabránit nové registraci původního uživatelského jména',
	'renamewiki_userwarnings' => 'Upozornění:',
	'renamewiki_userconfirm' => 'Ano, přejmenovat uživatele',
	'renamewiki_usersubmit' => 'Přejmenovat',
	'renamewiki_user-submit-blocklog' => 'Zobrazit knihu zablokování tohoto uživatele',
	'renamewiki_usererrordoesnotexist' => 'Uživatel se jménem „<nowiki>$1</nowiki>“ neexistuje',
	'renamewiki_usererrorexists' => 'Uživatel se jménem „<nowiki>$1</nowiki>“ již existuje',
	'renamewiki_usererrorinvalid' => 'Uživatelské jméno „<nowiki>$1</nowiki>“ nelze použít',
	'renamewiki_user-error-request' => 'Při přijímání požadavku došlo k chybě. Vraťte se a zkuste to znovu.',
	'renamewiki_user-error-same-wiki_user' => 'Nové uživatelské jméno je stejné jako dosavadní.',
	'renamewiki_usersuccess' => 'Uživatel „<nowiki>$1</nowiki>“ byl úspěšně přejmenován na „<nowiki>$2</nowiki>“',
	'renamewiki_user-page-exists' => 'Stránka $1 již existuje a nelze ji automaticky přepsat.',
	'renamewiki_user-page-moved' => 'Stránka $1 byla přesunuta na $2.',
	'renamewiki_user-page-unmoved' => 'Stránku $1 se nepodařilo přesunout na $2.',
	'renamewiki_userlogpage' => 'Kniha přejmenování uživatelů',
	'renamewiki_userlogpagetext' => 'Toto je záznam přejmenování uživatelů (změn uživatelského jména).',
	'renamewiki_userlogentry' => 'přejmenovává $1 na „$2“',
	'renamewiki_user-log' => '{{PLURAL:$1|1 editace|$1 editace|$1 editací}}. Zdůvodnění: $2',
	'renamewiki_user-move-log' => 'Automatický přesun při přejmenování uživatele „[[wiki_user:$1|$1]]“ na „[[wiki_user:$2|$2]]“',
	'action-renamewiki_user' => 'přejmenovávat uživatele',
	'right-renamewiki_user' => 'Přejmenovávání uživatelů',
	'renamewiki_user-renamed-notice' => 'Tento uživatel byl přejmenován.
Pro přehled je níže zobrazen výpis z knihy přejmenování uživatelů.',
);

/** Church Slavic (словѣ́ньскъ / ⰔⰎⰑⰂⰡⰐⰠⰔⰍⰟ)
 * @author Svetko
 * @author ОйЛ
 */
$messages['cu'] = array(
	'renamewiki_user' => 'прѣимєноуи польꙃєватєл҄ь',
	'renamewiki_userold' => 'нꙑнѣщьнѥѥ имѧ :',
	'renamewiki_usernew' => 'ново имѧ :',
	'renamewiki_userreason' => 'какъ съмꙑслъ :',
	'renamewiki_usermove' => 'нарьци тако польꙃєватєлꙗ страницѫ · бєсѣдѫ и ихъ подъстраницѧ',
	'renamewiki_usersubmit' => 'єи',
	'renamewiki_usererrordoesnotexist' => 'польꙃєватєлꙗ ⁖ <nowiki>$1</nowiki> ⁖ нѣстъ',
	'renamewiki_usererrorexists' => 'польꙃєватєл҄ь ⁖ <nowiki>$1</nowiki> ⁖ ѥстъ ю',
	'renamewiki_usererrorinvalid' => 'имѧ ⁖ <nowiki>$1</nowiki> ⁖ нѣстъ годѣ',
	'renamewiki_userlogpage' => 'польꙃєватєлъ прѣимєнованиꙗ їсторїꙗ',
	'renamewiki_userlogpagetext' => 'сѥ ѥстъ їсторїꙗ польꙃєватєльскъ имєнъ иꙁмѣнѥниꙗ',
	'renamewiki_userlogentry' => 'нарєчє $1 имєньмь ⁖ $2 ⁖',
);

/** Chuvash (Чӑвашла)
 * @author FLAGELLVM DEI
 */
$messages['cv'] = array(
	'renamewiki_userconfirm' => 'Çапла, хутшăнакан ятне улăштармалла',
	'renamewiki_user-page-moved' => '$1 страницăн ятне $2 çине улăштарнă.',
);

/** Welsh (Cymraeg)
 * @author Lloffiwr
 */
$messages['cy'] = array(
	'renamewiki_user' => 'Ail-enwi defnyddiwr',
	'renamewiki_user-linkoncontribs' => "ail-enwi'r defnyddiwr",
	'renamewiki_user-linkoncontribs-text' => "Ail-enwi'r defnyddiwr hwn",
	'renamewiki_user-desc' => "Yn ychwanegu [[Special:Renamewiki_user|tudalen arbennig]] er mwyn gallu ail-enwi cyfrif defnyddiwr (sydd angen y gallu ''renamewiki_user'')",
	'renamewiki_userold' => 'Enw presennol y defnyddiwr:',
	'renamewiki_usernew' => "Enw newydd i'r defnyddiwr:",
	'renamewiki_userreason' => 'Y rheswm dros ail-enwi:',
	'renamewiki_usermove' => "Symud y tudalennau defnyddiwr a sgwrs (ac unrhyw is-dudalennau) i'r enw newydd",
	'renamewiki_usersuppress' => "Peidiwch â gosod ailgyfeiriadau i'r enw newydd",
	'renamewiki_userreserve' => 'Atal yr hen enw defnyddiwr rhag cael ei ddefnyddio rhagor',
	'renamewiki_userwarnings' => 'Rhybuddion:',
	'renamewiki_userconfirm' => "Parhau gyda'r ail-enwi",
	'renamewiki_usersubmit' => 'Anfon',
	'renamewiki_user-submit-blocklog' => "Dangoser lòg rhwystro'r defnyddiwr",
	'renamewiki_usererrordoesnotexist' => 'Nid yw\'r defnyddiwr "<nowiki>$1</nowiki>" yn bodoli.',
	'renamewiki_usererrorexists' => 'Mae\'r defnyddiwr "<nowiki>$1</nowiki>" eisoes yn bodoli.',
	'renamewiki_usererrorinvalid' => 'Mae\'r enw defnyddiwr "<nowiki>$1</nowiki>" yn annilys',
	'renamewiki_user-error-request' => 'Cafwyd trafferth yn derbyn y cais.
Ewch yn ôl a cheisio eto, os gwelwch yn dda.',
	'renamewiki_user-error-same-wiki_user' => "Ni ellir ail-enwi defnyddiwr gyda'r un enw ag o'r blaen.",
	'renamewiki_usersuccess' => 'Mae\'r defnyddiwr "<nowiki>$1</nowiki>" wedi cael ei ail-enwi i "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => "Mae'r dudalen $1 ar gael yn barod ac ni ellir ei throsysgrifo.",
	'renamewiki_user-page-moved' => 'Symudwyd $1 i $2.',
	'renamewiki_user-page-unmoved' => 'Ni lwyddwyd i symud y dudalen $1 i $2.',
	'renamewiki_userlogpage' => 'Lòg ail-enwi defnyddwyr',
	'renamewiki_userlogpagetext' => "Dyma lòg o'r holl newidiadau i enwau defnyddwyr.",
	'renamewiki_userlogentry' => 'wedi ail-enwi $1 yn "$2"',
	'renamewiki_user-log' => '$1 {{PLURAL:$1|golygiad|golygiad|olygiad|golygiad|golygiad|o olygiadau}}. Rheswm: $2',
	'renamewiki_user-move-log' => 'Wedi symud y dudalen yn awtomatig wrth ail-enwi\'r defnyddiwr "[[wiki_user:$1|$1]]" i "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'ail-enwi defnyddwyr',
	'right-renamewiki_user' => 'Ail-enwi defnyddwyr',
	'renamewiki_user-renamed-notice' => "Mae'r defnyddiwr hwn wedi ei ail-enwi.
Mae'r lòg ail-enwi defnyddwyr i'w weld isod.",
);

/** Danish (dansk)
 * @author Byrial
 * @author Froztbyte
 * @author Hylle
 * @author Peter Alberti
 */
$messages['da'] = array(
	'renamewiki_user' => 'Omdøb bruger',
	'renamewiki_user-linkoncontribs' => 'omdøb bruger',
	'renamewiki_user-linkoncontribs-text' => 'Omdøb denne bruger',
	'renamewiki_user-desc' => "Laver en [[Special:Renamewiki_user|specialside]] til at omdøbe en bruger (kræver rettigheden ''renamewiki_user'')",
	'renamewiki_userold' => 'Nuværende brugernavn:',
	'renamewiki_usernew' => 'Nyt brugernavn:',
	'renamewiki_userreason' => 'Årsag til omdøbning:',
	'renamewiki_usermove' => 'Flyt bruger- og diskussionssider (og deres undersider) til nyt navn',
	'renamewiki_usersuppress' => 'Opret ikke omdirigeringer til det nye navn',
	'renamewiki_userreserve' => 'Bloker det gamle brugernavn fra fremtidig brug',
	'renamewiki_userwarnings' => 'Advarsler:',
	'renamewiki_userconfirm' => 'Ja, omdøb brugeren',
	'renamewiki_usersubmit' => 'Omdøb',
	'renamewiki_usererrordoesnotexist' => 'Brugeren "<nowiki>$1</nowiki>" findes ikke.',
	'renamewiki_usererrorexists' => 'Brugeren "<nowiki>$1</nowiki>" findes allerede.',
	'renamewiki_usererrorinvalid' => 'Brugernavnet "<nowiki>$1</nowiki>" er ugyldigt.',
	'renamewiki_user-error-request' => 'Det var et problem med at modtage forespørgslen.
Gå venligst tilbage og prøv igen.',
	'renamewiki_user-error-same-wiki_user' => 'Du kan ikke omdøbe en bruger til det samme navn som før.',
	'renamewiki_usersuccess' => 'Brugeren "<nowiki>$1</nowiki>" er blevet omdøbt til "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Siden $1 eksisterer allerede og kan ikke automatisk overskrives.',
	'renamewiki_user-page-moved' => 'Siden $1 er flyttet til $2.',
	'renamewiki_user-page-unmoved' => 'Siden $1 kunne ikke flyttes til $2.',
	'renamewiki_userlogpage' => 'Brugeromdøbningslog',
	'renamewiki_userlogpagetext' => 'Dette er en log over omdøbninger af brugernavne.',
	'renamewiki_userlogentry' => 'har omdøbt $1 til "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 redigering|$1 redigeringer}}. Årsag: $2',
	'renamewiki_user-move-log' => 'Side automatisk flyttet ved omdøbning af bruger "[[wiki_user:$1|$1]]" til "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'omdøb brugere',
	'right-renamewiki_user' => 'Omdøbe brugere',
	'renamewiki_user-renamed-notice' => 'Denne bruger er blevet omdøbt.
Til information er omdøbningsloggen vist nedenfor.',
);

/** German (Deutsch)
 * @author Kghbln
 * @author Raimond Spekking
 * @author Spacebirdy
 * @author The Evil IP address
 * @author Umherirrender
 */
$messages['de'] = array(
	'renamewiki_user' => 'Benutzer umbenennen',
	'renamewiki_user-linkoncontribs' => 'Benutzer umbenennen',
	'renamewiki_user-linkoncontribs-text' => 'Diesen Benutzer umbenennen',
	'renamewiki_user-desc' => 'Ergänzt eine [[Special:Renamewiki_user|Spezialseite]] zum Umbenennen eines Benutzers',
	'renamewiki_userold' => 'Bisheriger Benutzername:',
	'renamewiki_usernew' => 'Neuer Benutzername:',
	'renamewiki_userreason' => 'Grund:',
	'renamewiki_usermove' => 'Benutzer-/Diskussionsseite (inkl. Unterseiten) auf den neuen Benutzernamen verschieben',
	'renamewiki_usersuppress' => 'Weiterleitung auf den neuen Benutzernamen unterdrücken',
	'renamewiki_userreserve' => 'Alten Benutzernamen für eine Neuregistrierung blockieren',
	'renamewiki_userwarnings' => 'Warnungen:',
	'renamewiki_userconfirm' => 'Ja, Benutzer umbenennen',
	'renamewiki_usersubmit' => 'Umbenennen',
	'renamewiki_user-submit-blocklog' => 'Benutzersperr-Logbuch zum Benutzer anzeigen',
	'renamewiki_usererrordoesnotexist' => 'Der Benutzername „<nowiki>$1</nowiki>“ ist nicht vorhanden.',
	'renamewiki_usererrorexists' => 'Der Benutzername „<nowiki>$1</nowiki>“ ist bereits vorhanden.',
	'renamewiki_usererrorinvalid' => 'Der Benutzername „<nowiki>$1</nowiki>“ ist ungültig.',
	'renamewiki_user-error-request' => 'Es gab ein Problem beim Empfang der Anfrage.
Bitte nochmal versuchen.',
	'renamewiki_user-error-same-wiki_user' => 'Alter und neuer Benutzername sind identisch.',
	'renamewiki_usersuccess' => 'Der Benutzer „<nowiki>$1</nowiki>“ wurde erfolgreich in „<nowiki>$2</nowiki>“ umbenannt.',
	'renamewiki_user-page-exists' => 'Die Seite „$1“ ist bereits vorhanden und kann nicht automatisch überschrieben werden.',
	'renamewiki_user-page-moved' => 'Die Seite „$1“ wurde nach „$2“ verschoben.',
	'renamewiki_user-page-unmoved' => 'Die Seite „$1“ konnte nicht nach „$2“ verschoben werden.',
	'renamewiki_userlogpage' => 'Benutzernamenänderungs-Logbuch',
	'renamewiki_userlogpagetext' => 'In diesem Logbuch werden die Änderungen von Benutzernamen protokolliert.',
	'renamewiki_userlogentry' => 'hat „$1“ in „$2“ umbenannt',
	'renamewiki_user-log' => '{{PLURAL:$1|Eine Bearbeitung|$1 Bearbeitungen}}. Grund: $2',
	'renamewiki_user-move-log' => 'Seite während der Benutzerkontoumbenennung von „[[wiki_user:$1|$1]]“ in „[[wiki_user:$2|$2]]“ automatisch verschoben',
	'action-renamewiki_user' => 'Benutzer umzubenennen',
	'right-renamewiki_user' => 'Benutzer umbenennen',
	'renamewiki_user-renamed-notice' => '{{GENDER:$1|Dieser Benutzer|Diese Benutzerin|Dieser Benutzer}} wurde umbenannt.
Zur Information folgt das Benutzernamenänderungs-Logbuch.',
);

/** Zazaki (Zazaki)
 * @author Aspar
 * @author Erdemaslancan
 * @author Xoser
 */
$messages['diq'] = array(
	'renamewiki_user' => 'nameyê karberi bıvurn',
	'renamewiki_user-linkoncontribs' => 'name bivurne',
	'renamewiki_user-linkoncontribs-text' => 'Nameyê ena karber bivurne',
	'renamewiki_user-desc' => "qey newe ra namedayişê karberi re yew [[Special:Renamewiki_user|pelo xas]] têare keno (gani heqqê ''karberi re newe ra name bıde'' bıbo )",
	'renamewiki_userold' => 'nameyê karberi yo nıkayi',
	'renamewiki_usernew' => 'nameyê karberi yo newe',
	'renamewiki_userreason' => 'çıra:',
	'renamewiki_usermove' => 'nameyê karberan u pelê werêaameyişan bıkırışi nameyo newe',
	'renamewiki_usersuppress' => 'Name de newi re hetenayışo newe vıraştış',
	'renamewiki_userreserve' => 'nameyê karberi yo verini bloke bıker.',
	'renamewiki_userwarnings' => 'hişyariyi',
	'renamewiki_userconfirm' => 'bele karberi newe ra name bıker',
	'renamewiki_usersubmit' => 'bierşawê/biruşnê',
	'renamewiki_user-submit-blocklog' => 'Rocekanê bloqandê karbari bıvin',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" no name de yew karber çino.',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" karber ca ra esto',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" nameyê karberi nemeqbulo',
	'renamewiki_user-error-request' => 'ca ardışê waştışê şıma de yew problem veciya.
kerem kerê agêrê newe ra tesel bıkerê, bıcerbnê',
	'renamewiki_user-error-same-wiki_user' => 'şıma nêşkeni nameyê karberi yo verini reyna biyarî pakerî',
	'renamewiki_usersuccess' => '"<nowiki>$1</nowiki>" rumuzê no karberi yo cıwa verın vuriya "<nowiki>$2</nowiki>" no rumuzi re.',
	'renamewiki_user-page-exists' => '$1 pel ca ra esto newe ra ser nênusiyeno.',
	'renamewiki_user-page-moved' => '$1 pel kırışiya no $2 pel',
	'renamewiki_user-page-unmoved' => '$1 pel nêkırışiya no $2 pel.',
	'renamewiki_userlogpage' => 'qeydê vuriyayişê nameyê karberi',
	'renamewiki_userlogpagetext' => 'listeya cêrıni nameyê karberê ke vuriyayo mocneno',
	'renamewiki_userlogentry' => '$1newe ra neme bı: "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 edit|$1 edit}}. çıra: $2',
	'renamewiki_user-move-log' => 'wexta ke karber "[[wiki_user:$1|$1]]" no name ra kırışiya "[[wiki_user:$2|$2]]" no name re ya newe ra name diyêne pel zi otomotikmen kırişiya',
	'action-renamewiki_user' => 'nameyê karberi bıvurne',
	'right-renamewiki_user' => 'nameyê karberan bıvurn',
	'renamewiki_user-renamed-notice' => 'nameyê na/no karberi/e vuriya.
qey referansi rocaneyê vuriyayişê nameyi cêr de yo.',
);

/** Lower Sorbian (dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'renamewiki_user' => 'Wužywarja pśemjeniś',
	'renamewiki_user-linkoncontribs' => 'wužywarja psemjenjowaś',
	'renamewiki_user-linkoncontribs-text' => 'Toś togo wužywarja pśemjenjowaś',
	'renamewiki_user-desc' => "Wužywarja pśemjeniś (pomina se pšawo ''renamewiki_user'')",
	'renamewiki_userold' => 'Aktualne wužywarske mě:',
	'renamewiki_usernew' => 'Nowe wužywarske mě:',
	'renamewiki_userreason' => 'Pśicyna za pśemjenjenje',
	'renamewiki_usermove' => 'Wužywarski a diskusijny bok (a jich pódboki) do nowego mjenja pśesunuś',
	'renamewiki_usersuppress' => 'Dalejpósrědnjenja k nowemu mjenjoju njenapóraś',
	'renamewiki_userreserve' => 'Stare wužywarske mě pśeśiwo pśichodnemu wužywanjeju blokěrowaś',
	'renamewiki_userwarnings' => 'Warnowanja:',
	'renamewiki_userconfirm' => 'Jo, wužywarja pśemjeniś',
	'renamewiki_usersubmit' => 'Pśemjeniś',
	'renamewiki_user-submit-blocklog' => 'Blokěrowański protokol za wužywarja pokazaś',
	'renamewiki_usererrordoesnotexist' => 'Wužywaŕ "<nowiki>$1</nowiki>" njeeksistěrujo.',
	'renamewiki_usererrorexists' => 'Wužywaŕ "<nowiki>$1</nowiki>" južo eksistěrujo.',
	'renamewiki_usererrorinvalid' => 'Wužywarske mě "<nowiki>$1</nowiki>" jo njepłaśiwe.',
	'renamewiki_user-error-request' => 'Problem jo pśi dostawanju napšašanja wustupił.
Źi pšosym slědk a wopytaj hyšći raz.',
	'renamewiki_user-error-same-wiki_user' => 'Njamóžoš wužywarja do togo samogo mjenja pśemjeniś',
	'renamewiki_usersuccess' => 'Wužywaŕ "<nowiki>$1</nowiki>" jo se do "<nowiki>$2</nowiki>" pśemjenił.',
	'renamewiki_user-page-exists' => 'Bok $1 južo eksistěrujo a njedajo se awtomatiski pśepisaś.',
	'renamewiki_user-page-moved' => 'Bok $1 jo se do $2 pśesunuł.',
	'renamewiki_user-page-unmoved' => 'Bok $1 njejo se do $2 pśesunuś dał.',
	'renamewiki_userlogpage' => 'Protokol wužywarskich pśemjenjenjow',
	'renamewiki_userlogpagetext' => 'Toś to jo protokol změnow na wužywarskich mjenjach.',
	'renamewiki_userlogentry' => 'jo $1 do "$2" pśemjenił',
	'renamewiki_user-log' => '{{PLURAL:&1|1 změna|$1 změnje|$1 změny|$1 změnow}}. Pśicyna: $2',
	'renamewiki_user-move-log' => 'Pśi pśemjenjowanju wužywarja "[[wiki_user:$1|$1]]" do "[[wiki_user:$2|$2]]" awtomatiski pśesunjony bok',
	'action-renamewiki_user' => 'wužywarjow pśemjeniś',
	'right-renamewiki_user' => 'Wužywarjow pśemjeniś',
	'renamewiki_user-renamed-notice' => 'Toś ten wužywaŕ jo se pśemjenił.
Protokol pśemjenjowanjow jo dołojce ako referenca pódany.',
);

/** Greek (Ελληνικά)
 * @author Badseed
 * @author Consta
 * @author Dead3y3
 * @author Glavkos
 * @author Kiriakos
 * @author MF-Warburg
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'renamewiki_user' => 'Μετονομασία χρήστη',
	'renamewiki_user-linkoncontribs' => 'Μετονομασία χρήστη',
	'renamewiki_user-linkoncontribs-text' => 'Μετονομασία αυτού του χρήστη',
	'renamewiki_user-desc' => "Προσθέτει μια [[Special:Renamewiki_user|ειδική σελίδα]] για την μετονομασία ενός χρήστη (είναι απαραίτητο το δικαίωμα ''renamewiki_user'')",
	'renamewiki_userold' => 'Τρέχον όνομα χρήστη:',
	'renamewiki_usernew' => 'Νέο όνομα χρήστη:',
	'renamewiki_userreason' => 'Λόγος μετονομασίας:',
	'renamewiki_usermove' => 'Μετακίνηση της σελίδας χρήστη και της σελίδας συζήτησης χρήστη (και των υποσελίδων τους) στο καινούργιο όνομα',
	'renamewiki_usersuppress' => 'Μην δημιουργείτε ανακατευθύνσεις στο νέο όνομα',
	'renamewiki_userreserve' => 'Φραγή του παλιού ονόματος χρήστη/χρήστριας από μελλοντική χρήση',
	'renamewiki_userwarnings' => 'Προειδοποιήσεις:',
	'renamewiki_userconfirm' => 'Ναι, μετονομάστε τον χρήστη',
	'renamewiki_usersubmit' => 'Καταχώριση',
	'renamewiki_usererrordoesnotexist' => 'Ο χρήστης "<nowiki>$1</nowiki>" δεν υπάρχει',
	'renamewiki_usererrorexists' => 'Ο χρήστης "<nowiki>$1</nowiki>" υπάρχει ήδη.',
	'renamewiki_usererrorinvalid' => 'Το όνομα χρήστη "<nowiki>$1</nowiki>" είναι άκυρο.',
	'renamewiki_user-error-request' => 'Υπήρξε ένα πρόβλημα στην παραλαβή της αίτησης. Παρακαλούμε επιστρέψτε και ξαναδοκιμάστε.',
	'renamewiki_user-error-same-wiki_user' => 'Δεν μπορείτε να μετονομάσετε έναν χρήστη σε όνομα ίδιο με το προηγούμενο.',
	'renamewiki_usersuccess' => 'Ο χρήστης ή η χρήστρια «<nowiki>$1</nowiki>» έχει μετονομαστεί σε «<nowiki>$2</nowiki>».',
	'renamewiki_user-page-exists' => 'Η σελίδα $1 υπάρχει ήδη και δεν μπορεί να αντικατασταθεί αυτόματα.',
	'renamewiki_user-page-moved' => 'Η σελίδα $1 μετακινήθηκε στο $2.',
	'renamewiki_user-page-unmoved' => 'Η σελίδα $1 δεν μπόρεσε να μετακινηθεί στο $2.',
	'renamewiki_userlogpage' => 'Αρχείο μετονομασίας χρηστών',
	'renamewiki_userlogpagetext' => 'Αυτό είναι ένα αρχείο καταγραφών αλλαγών σε ονόματα χρηστών',
	'renamewiki_userlogentry' => 'Ο/Η $1 μετονομάστηκε σε «$2»',
	'renamewiki_user-log' => '{{PLURAL:$1|1 επεξεργασία|$1 επεξεργασίες}}. Λόγος: $2',
	'renamewiki_user-move-log' => 'Η σελίδα μετακινήθηκε αυτόματα κατά τη μετονομασία του χρήστη "[[wiki_user:$1|$1]]" σε "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'μετονομασία χρηστών',
	'right-renamewiki_user' => 'Μετονομασία χρηστών',
	'renamewiki_user-renamed-notice' => 'Αυτός ο χρήστης άλλαξε όνομα
Tο ημερολόγιο επανονομασιών δίνεται παρακάτω για αναφορά.',
);

/** Esperanto (Esperanto)
 * @author ArnoLagrange
 * @author Tlustulimu
 * @author Yekrats
 */
$messages['eo'] = array(
	'renamewiki_user' => 'Alinomigi uzanton',
	'renamewiki_user-linkoncontribs' => 'renomigi uzanton',
	'renamewiki_user-linkoncontribs-text' => 'Renomigi ĉi tiun uzanton',
	'renamewiki_user-desc' => "Aldonas [[Special:Renamewiki_user|specialan paĝon]] por alinomigi uzanton (bezonas rajton ''renamewiki_user'')",
	'renamewiki_userold' => 'Aktuala salutnomo:',
	'renamewiki_usernew' => 'Nova salutnomo:',
	'renamewiki_userreason' => 'Kialo por alinomigo:',
	'renamewiki_usermove' => 'Movu uzantan kaj diskutan paĝojn (kaj ties subpaĝojn) al la nova nomo',
	'renamewiki_usersuppress' => 'Ne krei alidirektilojn al la nova nomo',
	'renamewiki_userreserve' => 'Teni la malnovan salutnomon de plua uzo',
	'renamewiki_userwarnings' => 'Avertoj:',
	'renamewiki_userconfirm' => 'Jes, renomigu la uzanton',
	'renamewiki_usersubmit' => 'Ek',
	'renamewiki_user-submit-blocklog' => 'Montru forbarprotokolon de la uzulo',
	'renamewiki_usererrordoesnotexist' => 'La uzanto "<nowiki>$1</nowiki>" ne ekzistas',
	'renamewiki_usererrorexists' => 'La uzanto "<nowiki>$1</nowiki>" jam ekzistas',
	'renamewiki_usererrorinvalid' => 'La salutnomo "<nowiki>$1</nowiki>" estas malvalida',
	'renamewiki_user-error-request' => 'Estis problemo recivante la peton.
Bonvolu retroigi kaj reprovi.',
	'renamewiki_user-error-same-wiki_user' => 'Vi ne povas alinomigi uzanton al la sama nomo.',
	'renamewiki_usersuccess' => 'La uzanto "<nowiki>$1</nowiki>" estas alinomita al "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'La paĝo $1 jam ekzistas kaj ne povas esti aŭtomate anstataŭata.',
	'renamewiki_user-page-moved' => 'La paĝo $1 estis movita al $2.',
	'renamewiki_user-page-unmoved' => 'La paĝo $1 ne povis esti movita al $2.',
	'renamewiki_userlogpage' => 'Protokolo pri alinomigoj de uzantoj',
	'renamewiki_userlogpagetext' => 'Jen protokolo pri ŝanĝoj de salutnomoj.',
	'renamewiki_userlogentry' => 'renomigis $1 al "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 redakto|$1 redaktoj}}. Kialo: $2',
	'renamewiki_user-move-log' => 'Aŭtomate movis paĝon dum alinomigo de la uzanto "[[wiki_user:$1|$1]]" al "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'Alinomigi uzantojn',
	'right-renamewiki_user' => 'Alinomigi uzantojn',
	'renamewiki_user-renamed-notice' => 'Ĉi tiu uzanto estis renomigita.
Jen la protokolo pri renomigado por via referenco.',
);

/** Spanish (español)
 * @author Alhen
 * @author Armando-Martin
 * @author Dferg
 * @author Diego Grez
 * @author Icvav
 * @author Jatrobat
 * @author Lin linao
 * @author Locos epraix
 * @author Remember the dot
 * @author Sanbec
 * @author Spacebirdy
 * @author Translationista
 * @author Vivaelcelta
 */
$messages['es'] = array(
	'renamewiki_user' => 'Cambiar el nombre de usuario',
	'renamewiki_user-linkoncontribs' => 'cambiar el nombre de este usuario',
	'renamewiki_user-linkoncontribs-text' => 'Cambiar el nombre de este usuario',
	'renamewiki_user-desc' => "Añade una [[Special:Renamewiki_user|página especial]] para cambiar de nombre a un usuario (necesita el derecho ''renamewiki_user'')",
	'renamewiki_userold' => 'Nombre actual:',
	'renamewiki_usernew' => 'Nuevo nombre de usuario:',
	'renamewiki_userreason' => 'Motivo:',
	'renamewiki_usermove' => 'Trasladar las páginas de usuario y de discusión (y sus subpáginas) al nuevo nombre',
	'renamewiki_usersuppress' => 'No crear redirecciones al nuevo nombre',
	'renamewiki_userreserve' => 'Bloquear el antiguo nombre de usuario para evitar que sea usado en el futuro',
	'renamewiki_userwarnings' => 'Avisos:',
	'renamewiki_userconfirm' => 'Sí, cambiar el nombre del usuario',
	'renamewiki_usersubmit' => 'Enviar',
	'renamewiki_user-submit-blocklog' => 'Mostrar el registro de bloqueo para el usuario',
	'renamewiki_usererrordoesnotexist' => 'El usuario «<nowiki>$1</nowiki>» no existe',
	'renamewiki_usererrorexists' => 'El usuario «<nowiki>$1</nowiki>» ya existe',
	'renamewiki_usererrorinvalid' => 'El nombre de usuario «<nowiki>$1</nowiki>» no es válido',
	'renamewiki_user-error-request' => 'Hubo un problema al recibir la solicitud.
Por favor, vuelve atrás e inténtalo de nuevo.',
	'renamewiki_user-error-same-wiki_user' => 'No puedes renombrar a un usuario con el nombre que ya tenía.',
	'renamewiki_usersuccess' => 'El nombre de usuario «<nowiki>$1</nowiki>» ha sido modificado a «<nowiki>$2</nowiki>»',
	'renamewiki_user-page-exists' => 'La página $1 ya existe y no puede ser reemplazada automáticamente.',
	'renamewiki_user-page-moved' => 'La página $1 ha sido trasladada a $2.',
	'renamewiki_user-page-unmoved' => 'La página $1 no pudo ser trasladada a $2.',
	'renamewiki_userlogpage' => 'Registro de cambios de nombre de usuario',
	'renamewiki_userlogpagetext' => 'Este es un registro de cambios de nombres de usuario.',
	'renamewiki_userlogentry' => 'cambió el nombre de usuario de $1 a «$2»',
	'renamewiki_user-log' => '{{PLURAL:$1|1 edición|$1 ediciones}}. Motivo: $2',
	'renamewiki_user-move-log' => 'Página trasladada automáticamente al cambiar el nombre de usuario de «[[wiki_user:$1|$1]]» a «[[wiki_user:$2|$2]]»',
	'action-renamewiki_user' => 'Cambiar el nombre de los usuarios',
	'right-renamewiki_user' => 'Cambiar el nombre de los usuarios',
	'renamewiki_user-renamed-notice' => 'El nombre de este usuario ha sido modificado.
El registro de cambios de nombre de usuario se provee debajo para mayor referencia.',
);

/** Estonian (eesti)
 * @author Avjoska
 * @author Jaan513
 * @author Pikne
 * @author Silvar
 * @author WikedKentaur
 */
$messages['et'] = array(
	'renamewiki_user' => 'Kasutajanime muutmine',
	'renamewiki_user-linkoncontribs' => 'kasutaja ümbernimetamine',
	'renamewiki_user-linkoncontribs-text' => 'Nimeta see kasutaja ümber',
	'renamewiki_user-desc' => "Lisab kasutajanime muutmise [[Special:Renamewiki_user|erilehekülje]] (vajab ''renamewiki_user''-õigust).",
	'renamewiki_userold' => 'Praegune kasutajanimi:',
	'renamewiki_usernew' => 'Uus kasutajanimi:',
	'renamewiki_userreason' => 'Muutmise põhjus:',
	'renamewiki_usermove' => 'Nimeta ümber kasutajaleht, aruteluleht ja nende alamlehed.',
	'renamewiki_usersuppress' => 'Ära loo ümbersuunamisi uuele nimele',
	'renamewiki_userreserve' => 'Ära luba vana kasutajanime edaspidi kasutada',
	'renamewiki_userwarnings' => 'Hoiatused:',
	'renamewiki_userconfirm' => 'Jah, nimeta kasutaja ümber',
	'renamewiki_usersubmit' => 'Muuda',
	'renamewiki_user-submit-blocklog' => 'Näita blokeerimislogi sissekandeid',
	'renamewiki_usererrordoesnotexist' => 'Kasutajat "<nowiki>$1</nowiki>" ei ole olemas.',
	'renamewiki_usererrorexists' => 'Kasutaja "<nowiki>$1</nowiki>" on juba olemas.',
	'renamewiki_usererrorinvalid' => 'Kasutajanimi "<nowiki>$1</nowiki>" on vigane.',
	'renamewiki_user-error-request' => 'Palvet ei õnnestunud kätte saada.
Palun ürita uuesti.',
	'renamewiki_user-error-same-wiki_user' => 'Vana ja uus nimi on samased.',
	'renamewiki_usersuccess' => 'Kasutaja "<nowiki>$1</nowiki>" uus nimi on nüüd "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Lehekülg $1 on juba olemas ja seda ei saa automaatselt üle kirjutada.',
	'renamewiki_user-page-moved' => 'Lehekülg $1 on teisaldatud pealkirja $2 alla.',
	'renamewiki_user-page-unmoved' => 'Lehekülje $1 teisaldamine nime $2 alla ei õnnestunud.',
	'renamewiki_userlogpage' => 'Kasutajanime muutmise logi',
	'renamewiki_userlogpagetext' => 'See on kasutajanimede muutmise logi.',
	'renamewiki_userlogentry' => 'nimetas kasutaja $1 ümber kasutajaks "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 redigeerimine|$1 redigeerimist}}. Põhjus: $2',
	'renamewiki_user-move-log' => 'Teisaldatud automaatselt, kui kasutaja "[[wiki_user:$1|$1]]" nimetati ümber kasutajaks "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'kasutajaid ümber nimetadata',
	'right-renamewiki_user' => 'Muuta kasutajanimesid',
	'renamewiki_user-renamed-notice' => 'Kasutaja on ümbernimetatud.
Allpool on toodud ümbernimetamislogi.',
);

/** Basque (euskara)
 * @author An13sa
 * @author Theklan
 */
$messages['eu'] = array(
	'renamewiki_user' => 'Erabiltzaile bati izena aldatu',
	'renamewiki_userold' => 'Oraingo erabiltzaile izena:',
	'renamewiki_usernew' => 'Erabiltzaile izen berria:',
	'renamewiki_userreason' => 'Izena aldatzeko arrazoia:',
	'renamewiki_userwarnings' => 'Oharrak:',
	'renamewiki_userconfirm' => 'Bai, lankidearen izena aldatu',
	'renamewiki_usersubmit' => 'Bidali',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" lankidea existitzen da',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" erabiltzaile izena okerra da',
	'renamewiki_usersuccess' => '"<nowiki>$1</nowiki>" lankidearen izen berria "<nowiki>$2</nowiki>" da',
	'renamewiki_user-page-exists' => 'Badago $1 orrialdea, eta ezin da automatikoki gainidatzi.',
	'renamewiki_user-page-moved' => '$1 orrialde $2(e)ra mugitu da.',
	'renamewiki_user-page-unmoved' => 'Ezin izan da $1 orrialdea $2(e)ra mugitu.',
	'renamewiki_userlogpage' => 'Erabiltzaileen izen aldaketa erregistroa',
	'renamewiki_userlogpagetext' => 'Erabiltzaileen izen aldaketen erregistroa da hau',
	'renamewiki_user-log' => '{{PLURAL:$1|aldaketa 1|$1 aldaketa}}. Arrazoia: $2',
	'right-renamewiki_user' => 'Lankideak berrizendatu',
);

/** Extremaduran (estremeñu)
 * @author Better
 */
$messages['ext'] = array(
	'renamewiki_user-page-moved' => 'S´á moviu la páhina $1 a $2.',
);

/** Persian (فارسی)
 * @author Ebraminio
 * @author Huji
 * @author Reza1615
 * @author Wayiran
 */
$messages['fa'] = array(
	'renamewiki_user' => 'تغییر نام کاربر',
	'renamewiki_user-linkoncontribs' => 'تغییر نام کاربر',
	'renamewiki_user-linkoncontribs-text' => 'تغییر نام کاربر',
	'renamewiki_user-desc' => "نام یک کاربر را تغییر می‌دهد (نیازمند برخورداری از اختیارات ''تغییرنام'' است)",
	'renamewiki_userold' => 'نام کاربری کنونی:',
	'renamewiki_usernew' => 'نام کاربری نو:',
	'renamewiki_userreason' => 'علت تغییر نام کاربری:',
	'renamewiki_usermove' => 'صفحه‌های کاربری و بحث (به همراه زیر صفحه‌هایشان) به نام جدید منتقل کن',
	'renamewiki_usersuppress' => 'تغییرمسیر به نام جدید ایجاد نکن',
	'renamewiki_userreserve' => 'نام کاربری قبلی را در مقابل استفادهٔ مجدد حفظ کن',
	'renamewiki_userwarnings' => 'هشدار:',
	'renamewiki_userconfirm' => 'بله، نام کاربر را تغییر بده',
	'renamewiki_usersubmit' => 'ارسال',
	'renamewiki_user-submit-blocklog' => 'نمایش سیاههٔ بستن کاربر',
	'renamewiki_usererrordoesnotexist' => 'نام کاربری «<nowiki>$1</nowiki>» وجود ندارد',
	'renamewiki_usererrorexists' => 'نام کاربری «<nowiki>$1</nowiki>» استفاده شده‌است',
	'renamewiki_usererrorinvalid' => 'نام کاربری «<nowiki>$1</nowiki>» غیر مجاز است',
	'renamewiki_user-error-request' => 'در دریافت درخواست مشکلی پیش آمد. لطفاً به صفحهٔ قبل بازگردید و دوباره تلاش کنید.',
	'renamewiki_user-error-same-wiki_user' => 'شما نمی‌توانید نام یک کاربر را به همان نام قبلی‌اش تغییر دهید.',
	'renamewiki_usersuccess' => 'نام کاربر «<nowiki>$1</nowiki>» به «<nowiki>$2</nowiki>» تغییر یافت.',
	'renamewiki_user-page-exists' => 'صفحهٔ $1 از قبل وجود داشته و به طور خودکار قابل بازنویسی نیست.',
	'renamewiki_user-page-moved' => 'صفحهٔ $1 به $2 انتقال داده شد.',
	'renamewiki_user-page-unmoved' => 'امکان انتقال صفحهٔ $1 به $2 وجود ندارد.',
	'renamewiki_userlogpage' => 'سیاهه تغییر نام کاربر',
	'renamewiki_userlogpagetext' => 'این سیاههٔ تغییر نام کاربران است',
	'renamewiki_userlogentry' => 'نام $1 را به $2 تغییر داد',
	'renamewiki_user-log' => '$1 ویرایش. دلیل: $2',
	'renamewiki_user-move-log' => 'صفحه در ضمن تغییر نام «[[wiki_user:$1|$1]]» به «[[wiki_user:$2|$2]]» به طور خودکار انتقال داده شد.',
	'action-renamewiki_user' => 'تغییر نام کاربران',
	'right-renamewiki_user' => 'تغییر نام کاربران',
	'renamewiki_user-renamed-notice' => 'این کاربر تغییر نام داده‌است.
سیاهه تغییر نام در ادامه آمده است.',
);

/** Finnish (suomi)
 * @author Agony
 * @author Centerlink
 * @author Crt
 * @author Linnea
 * @author Nike
 * @author Pxos
 * @author Str4nd
 */
$messages['fi'] = array(
	'renamewiki_user' => 'Käyttäjätunnuksen vaihto',
	'renamewiki_user-linkoncontribs' => 'nimeä käyttäjä uudelleen',
	'renamewiki_user-linkoncontribs-text' => 'Nimeä tämä käyttäjä uudelleen',
	'renamewiki_user-desc' => "Mahdollistaa käyttäjän uudelleennimeämisen (vaatii ''renamewiki_user''-oikeudet).",
	'renamewiki_userold' => 'Nykyinen tunnus',
	'renamewiki_usernew' => 'Uusi tunnus',
	'renamewiki_userreason' => 'Kommentti',
	'renamewiki_usermove' => 'Siirrä käyttäjä- ja keskustelusivut alasivuineen uudelle nimelle',
	'renamewiki_usersuppress' => 'Älä luo ohjauksia uuteen nimeen',
	'renamewiki_userreserve' => 'Estä entinen käyttäjänimi tulevalta käytöltä',
	'renamewiki_userwarnings' => 'Varoitukset:',
	'renamewiki_userconfirm' => 'Kyllä, uudelleennimeä käyttäjä',
	'renamewiki_usersubmit' => 'Nimeä',
	'renamewiki_user-submit-blocklog' => 'Näytä käyttäjän estoloki',
	'renamewiki_usererrordoesnotexist' => 'Tunnusta ”<nowiki>$1</nowiki>” ei ole',
	'renamewiki_usererrorexists' => 'Tunnus ”<nowiki>$1</nowiki>” on jo olemassa',
	'renamewiki_usererrorinvalid' => 'Tunnus ”<nowiki>$1</nowiki>” ei ole kelvollinen',
	'renamewiki_user-error-request' => 'Pyynnön vastaanottamisessa oli ongelma. Ole hyvä ja yritä uudelleen.',
	'renamewiki_user-error-same-wiki_user' => 'Et voi nimetä käyttäjää uudelleen samaksi kuin hän jo on.',
	'renamewiki_usersuccess' => 'Käyttäjän ”<nowiki>$1</nowiki>” tunnus on nyt ”<nowiki>$2</nowiki>”.',
	'renamewiki_user-page-exists' => 'Sivu $1 on jo olemassa eikä sitä korvattu.',
	'renamewiki_user-page-moved' => 'Sivu $1 siirrettiin nimelle $2.',
	'renamewiki_user-page-unmoved' => 'Sivun $1 siirtäminen nimelle $2 ei onnistunut.',
	'renamewiki_userlogpage' => 'Tunnusten vaihdot',
	'renamewiki_userlogpagetext' => 'Tämä on loki käyttäjätunnuksien vaihdoista.',
	'renamewiki_userlogentry' => 'on nimennyt käyttäjän $1 käyttäjäksi ”$2”',
	'renamewiki_user-log' => 'Tehnyt {{PLURAL:$1|yhden muokkauksen|$1 muokkausta}}. $2',
	'renamewiki_user-move-log' => 'Siirretty automaattisesti tunnukselta ”[[wiki_user:$1|$1]]” tunnukselle ”[[wiki_user:$2|$2]]”',
	'action-renamewiki_user' => 'nimetä käyttäjätunnuksia uudelleen',
	'right-renamewiki_user' => 'Nimetä käyttäjätunnuksia uudelleen',
	'renamewiki_user-renamed-notice' => 'Tämä käyttäjä on nimetty uudelleen.
Alla on ote tunnusten vaihtolokista.',
);

/** Faroese (føroyskt)
 * @author EileenSanda
 * @author Spacebirdy
 */
$messages['fo'] = array(
	'renamewiki_user' => 'Umdoyp brúkara',
	'renamewiki_user-linkoncontribs' => 'umdoyp brúkara',
	'renamewiki_user-linkoncontribs-text' => 'Umdoyp henda brúkara',
	'renamewiki_userold' => 'Rætta brúkaranavn:',
	'renamewiki_usernew' => 'Nýtt brúkaranavn:',
	'renamewiki_userreason' => 'Orsøk til nýtt navn:',
	'renamewiki_userwarnings' => 'Ávaringar:',
	'renamewiki_userconfirm' => 'Ja, gev hesum brúkara nýtt navn',
	'renamewiki_usersubmit' => 'Send inn',
	'renamewiki_usererrordoesnotexist' => 'Brúkarin "<nowiki>$1</nowiki>" er ikki til.',
	'renamewiki_usererrorexists' => 'Brúkarin "<nowiki>$1</nowiki>" er long til.',
	'renamewiki_usererrorinvalid' => 'Brúkaranavnið "<nowiki>$1</nowiki>" er ógyldugt.',
	'renamewiki_user-error-request' => 'Har var ein trupulleiki við at móttaka fyrispurningin.
Vinarliga far aftur og royn enn einaferð.',
	'renamewiki_user-page-moved' => 'Síðan $1 er blivin flutt til $2.',
	'renamewiki_user-page-unmoved' => 'Síðan $1 kundi ikki verða flutt til $2.',
	'renamewiki_userlogentry' => 'umdoypti $1 til "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 rætting|$1 rættingar}}. Orsøk: $2',
	'right-renamewiki_user' => 'Umdoyp brúkarar',
	'renamewiki_user-renamed-notice' => 'Hesin brúkari hevur fingið nýtt navn.
Loggurin fyri navnabroytingina er givin niðanfyri fyri keldu ávísing.',
);

/** French (français)
 * @author Cedric31
 * @author Crochet.david
 * @author DavidL
 * @author Gomoko
 * @author Grondin
 * @author Hégésippe Cormier
 * @author IAlex
 * @author Peter17
 * @author PieRRoMaN
 * @author Urhixidur
 * @author Verdy p
 */
$messages['fr'] = array(
	'renamewiki_user' => 'Renommer l’utilisateur',
	'renamewiki_user-linkoncontribs' => 'renommer l’utilisateur',
	'renamewiki_user-linkoncontribs-text' => 'Renommer cet utilisateur',
	'renamewiki_user-desc' => "Renomme un utilisateur (nécessite les droits de ''renamewiki_user'')",
	'renamewiki_userold' => 'Nom actuel de l’utilisateur :',
	'renamewiki_usernew' => 'Nouveau nom de l’utilisateur :',
	'renamewiki_userreason' => 'Motif du changement de nom :',
	'renamewiki_usermove' => 'Renommer toutes les pages de l’utilisateur vers le nouveau nom',
	'renamewiki_usersuppress' => 'Ne pas créer de redirection vers le nouveau nom',
	'renamewiki_userreserve' => 'Réserver l’ancien nom pour un usage futur',
	'renamewiki_userwarnings' => 'Avertissements :',
	'renamewiki_userconfirm' => 'Oui, renommer l’utilisateur',
	'renamewiki_usersubmit' => 'Soumettre',
	'renamewiki_user-submit-blocklog' => "Afficher le journal de blocage de l'utilisateur",
	'renamewiki_usererrordoesnotexist' => 'L’utilisateur « <nowiki>$1</nowiki> » n’existe pas',
	'renamewiki_usererrorexists' => 'L’utilisateur « <nowiki>$1</nowiki> » existe déjà',
	'renamewiki_usererrorinvalid' => 'Le nom d’utilisateur « <nowiki>$1</nowiki> » n’est pas valide',
	'renamewiki_user-error-request' => 'Un problème existe avec la réception de la requête. Revenez en arrière et essayez à nouveau.',
	'renamewiki_user-error-same-wiki_user' => 'Vous ne pouvez pas renommer un utilisateur du même nom qu’auparavant.',
	'renamewiki_usersuccess' => 'L’utilisateur « <nowiki>$1</nowiki> » a été renommé « <nowiki>$2</nowiki> »',
	'renamewiki_user-page-exists' => 'La page $1 existe déjà et ne peut pas être automatiquement remplacée.',
	'renamewiki_user-page-moved' => 'La page $1 a été déplacée vers $2.',
	'renamewiki_user-page-unmoved' => 'La page $1 ne peut pas être renommée en $2.',
	'renamewiki_userlogpage' => 'Journal des changements de noms d’utilisateurs',
	'renamewiki_userlogpagetext' => 'Ceci est l’historique des changements de noms d’utilisateur',
	'renamewiki_userlogentry' => 'a renommé « $1 » en « $2 »',
	'renamewiki_user-log' => '$1 modification{{PLURAL:$1||s}}. Motif : $2',
	'renamewiki_user-move-log' => 'Page déplacée automatiquement lorsque l’utilisateur « [[wiki_user:$1|$1]] » est devenu « [[wiki_user:$2|$2]] »',
	'action-renamewiki_user' => 'renommer les utilisateurs',
	'right-renamewiki_user' => 'Renommer les utilisateurs',
	'renamewiki_user-renamed-notice' => 'Cet utilisateur a été renommé.
Le journal des renommages est disponible ci-dessous pour information.',
);

/** Franco-Provençal (arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'renamewiki_user' => 'Renomar l’usanciér',
	'renamewiki_user-linkoncontribs' => 'renomar l’usanciér',
	'renamewiki_user-linkoncontribs-text' => 'Renomar ceti usanciér',
	'renamewiki_user-desc' => "Apond una [[Special:Renamewiki_user|pâge spèciâla]] por renomar un usanciér (at fôta des drêts de ''renamewiki_user'').",
	'renamewiki_userold' => 'Nom d’ora a l’usanciér :',
	'renamewiki_usernew' => 'Novél nom a l’usanciér :',
	'renamewiki_userreason' => 'Rêson du changement de nom :',
	'renamewiki_usermove' => 'Renomar totes les pâges a l’usanciér vers lo novél nom',
	'renamewiki_usersuppress' => 'Pas fâre de redirèccion de vers lo novél nom',
	'renamewiki_userreserve' => 'Resèrvar lo viely nom por un usâjo a vegnir',
	'renamewiki_userwarnings' => 'Avèrtissements :',
	'renamewiki_userconfirm' => 'Ouè, renomar l’usanciér',
	'renamewiki_usersubmit' => 'Sometre',
	'renamewiki_usererrordoesnotexist' => 'L’usanciér « <nowiki>$1</nowiki> » ègziste pas.',
	'renamewiki_usererrorexists' => 'L’usanciér « <nowiki>$1</nowiki> » ègziste ja.',
	'renamewiki_usererrorinvalid' => 'Lo nom d’usanciér « <nowiki>$1</nowiki> » est envalido.',
	'renamewiki_user-error-request' => 'Un problèmo ègziste avouéc la reçua de la requéta.
Volyéd tornar arriér et pués tornar èprovar.',
	'renamewiki_user-error-same-wiki_user' => 'Vos pouede pas renomar un usanciér du mémo nom que dês devant.',
	'renamewiki_usersuccess' => 'L’usanciér « <nowiki>$1</nowiki> » at étâ renomâ en « <nowiki>$2</nowiki> ».',
	'renamewiki_user-page-exists' => 'La pâge $1 ègziste ja et pôt pas étre remplaciê ôtomaticament.',
	'renamewiki_user-page-moved' => 'La pâge $1 at étâ dèplaciê vers $2.',
	'renamewiki_user-page-unmoved' => 'La pâge $1 pôt pas étre renomâ en $2.',
	'renamewiki_userlogpage' => 'Jornal des changements de nom d’usanciér',
	'renamewiki_userlogpagetext' => 'O est lo jornal des changements de nom d’usanciér.',
	'renamewiki_userlogentry' => 'at renomâ « $1 » en « $2 »',
	'renamewiki_user-log' => '$1 changement{{PLURAL:$1||s}}. Rêson : $2',
	'renamewiki_user-move-log' => 'Pâge dèplaciê ôtomaticament quand l’usanciér « [[wiki_user:$1|$1]] » est vegnu « [[wiki_user:$2|$2]] »',
	'action-renamewiki_user' => 'renomar los utilisators',
	'right-renamewiki_user' => 'Renomar des usanciérs',
	'renamewiki_user-renamed-notice' => 'Ceti usanciér at étâ renomâ.
Lo jornal des changements de nom est disponiblo ce-desot por enformacion.',
);

/** Friulian (furlan)
 * @author Klenje
 */
$messages['fur'] = array(
	'renamewiki_user' => 'Cambie non par un utent',
	'renamewiki_userold' => 'Non utent atuâl:',
	'renamewiki_usernew' => 'Gnûf non utent:',
	'renamewiki_userwarnings' => 'Avîs:',
);

/** Western Frisian (Frysk)
 * @author SK-luuut
 * @author Snakesteuben
 */
$messages['fy'] = array(
	'renamewiki_user' => 'Feroarje in meidochnamme',
	'renamewiki_user-desc' => "Foeget in [[Special:Renamewiki_user|spesiale side]] ta om in meidoggersnamme te feroarjen (jo hawwe hjirfoar it ''renamewiki_user'' rjocht nedich)",
	'renamewiki_userold' => 'Alde namme:',
	'renamewiki_usernew' => 'Nije namme:',
	'renamewiki_userreason' => 'Reden foar nammewiziging:',
	'renamewiki_usermove' => 'Werneam meidogger en oerlis siden (mei ûnderlizzende siden) nei de nije namme',
	'renamewiki_userreserve' => 'Takomst brûken fan de âlde meidoggersnamme foarkomme',
	'renamewiki_userwarnings' => 'Warskôgings:',
	'renamewiki_userconfirm' => 'Ja, feroarje de namme fan de meidogger',
	'renamewiki_usersubmit' => 'Feroarje',
	'renamewiki_usererrordoesnotexist' => 'Der is gjin meidogger mei de namme "<nowiki>$1</nowiki>"',
	'renamewiki_usererrorexists' => 'De meidochnamme "<nowiki>$1</nowiki>" wurdt al brûkt.',
	'renamewiki_usererrorinvalid' => 'De meidochnamme "<nowiki>$1</nowiki>" mei net.',
	'renamewiki_user-error-request' => "Der wie in probleem mei it ferwurkjen fan de oanfraach.
Gean tebek en probearje it asjebleaft op 'e nij.",
	'renamewiki_user-error-same-wiki_user' => 'Jo kinne in meidoggersnamme net nei deselde namme feroarje.',
	'renamewiki_usersuccess' => 'Meidogger "<nowiki>$1</nowiki>" is no meidogger "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'De side $1 bestiet al en kin net automatysk oerskreaun wurde.',
	'renamewiki_user-page-moved' => 'Sidenamme $1 is feroare yn $2.',
	'renamewiki_user-page-unmoved' => 'Sidenamme $1 koe net feroare wurde yn $2.',
	'renamewiki_userlogpage' => 'Nammeferoar-loch',
	'renamewiki_userlogpagetext' => 'Dit is in loch fan feroarings fan meidochnammen.',
	'renamewiki_userlogentry' => 'hat de namme fan $1 feroare yn "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|ien feroaring|$1 feroarings}}. Reden: $2',
	'renamewiki_user-move-log' => 'Sidenamme automatysk feroare by it feroarjen fan de meidoggersnamme fan  "[[wiki_user:$1|$1]]" yn "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'Feroarje meidoggersnammen',
);

/** Irish (Gaeilge)
 * @author Alison
 */
$messages['ga'] = array(
	'renamewiki_user' => 'Athainmnigh úsáideoir',
	'renamewiki_userold' => 'Ainm reatha úsáideora:',
	'renamewiki_usernew' => 'Ainm nua úsáideora:',
	'renamewiki_usersuccess' => 'Athainmníodh úsáideoir "<nowiki>$1</nowiki>" mar "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'Tá leathanach "$1" ann chean féin; ní féidir ábhar a scríobh thairis go huathoibríoch.',
	'renamewiki_userlogentry' => 'athainmníodh úsáideoir $1 mar "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|Athrú amháin|$1 athruithe}}. Fáth: $2',
);

/** Galician (galego)
 * @author Alma
 * @author Prevert
 * @author Toliño
 */
$messages['gl'] = array(
	'renamewiki_user' => 'Mudar o nome do usuario',
	'renamewiki_user-linkoncontribs' => 'cambiar o nome do usuario',
	'renamewiki_user-linkoncontribs-text' => 'Cambiar o nome deste usuario',
	'renamewiki_user-desc' => "Engade unha [[Special:Renamewiki_user|páxina especial]] para renomear un usuario (precisa dereitos de ''renomear usuarios'')",
	'renamewiki_userold' => 'Nome de usuario actual:',
	'renamewiki_usernew' => 'Novo nome de usuario:',
	'renamewiki_userreason' => 'Motivo para mudar o nome:',
	'renamewiki_usermove' => 'Mover as páxinas de usuario e de conversa (xunto coas subpáxinas) ao novo nome',
	'renamewiki_usersuppress' => 'Non crear a redirección cara ao novo nome',
	'renamewiki_userreserve' => 'Reservar o nome de usuario vello para un uso posterior',
	'renamewiki_userwarnings' => 'Avisos:',
	'renamewiki_userconfirm' => 'Si, renomear este usuario',
	'renamewiki_usersubmit' => 'Enviar',
	'renamewiki_user-submit-blocklog' => 'Mostrar o rexistro de bloqueos do usuario',
	'renamewiki_usererrordoesnotexist' => 'O usuario "<nowiki>$1</nowiki>" non existe.',
	'renamewiki_usererrorexists' => 'O usuario "<nowiki>$1</nowiki>" xa existe.',
	'renamewiki_usererrorinvalid' => 'O nome de usuario "<nowiki>$1</nowiki>" non é válido.',
	'renamewiki_user-error-request' => 'Houbo un problema coa recepción da solicitude.
Volva atrás e inténteo de novo.',
	'renamewiki_user-error-same-wiki_user' => 'Non pode mudar o nome dun usuario ao mesmo nome que tiña antes.',
	'renamewiki_usersuccess' => 'O nome de usuario de "<nowiki>$1</nowiki>" cambiou a "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'A páxina "$1" xa existe e non pode ser sobrescrita automaticamente.',
	'renamewiki_user-page-moved' => 'A páxina "$1" foi movida a "$2".',
	'renamewiki_user-page-unmoved' => 'A páxina "$1" non pode ser movida a "$2".',
	'renamewiki_userlogpage' => 'Rexistro de cambios de nome de usuario',
	'renamewiki_userlogpagetext' => 'Este é un rexistro dos cambios nos nomes de usuario.',
	'renamewiki_userlogentry' => 'mudou o nome de "$1" a "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 edición|$1 edicións}}. Razón: $2',
	'renamewiki_user-move-log' => 'A páxina moveuse automaticamente cando se mudou o nome do usuario "[[wiki_user:$1|$1]]" a "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'renomear usuarios',
	'right-renamewiki_user' => 'Renomear usuarios',
	'renamewiki_user-renamed-notice' => 'Este usuario foi renomeado.
Velaquí está o rexistro de cambios de nome de usuario por se quere consultalo.',
);

/** Ancient Greek (Ἀρχαία ἑλληνικὴ)
 * @author Omnipaedista
 */
$messages['grc'] = array(
	'renamewiki_usersubmit' => 'Ὑποβάλλειν',
	'renamewiki_user-log' => '{{PLURAL:$1|1 μεταγραφή|$1 μεταγραφαί}}. Αίτία: $2',
);

/** Swiss German (Alemannisch)
 * @author Als-Chlämens
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'renamewiki_user' => 'Benutzer umnänne',
	'renamewiki_user-linkoncontribs' => 'Benutzer umnänne',
	'renamewiki_user-linkoncontribs-text' => 'Dää Benutzer umnänne',
	'renamewiki_user-desc' => "Ergänzt e [[Special:Renamewiki_user|Spezialsyte]] fir d Umnännig vun eme Benutzer (brucht s ''renamewiki_user''-Rächt)",
	'renamewiki_userold' => 'Bishärige Benutzername:',
	'renamewiki_usernew' => 'Neije Benutzername:',
	'renamewiki_userreason' => 'Grund:',
	'renamewiki_usermove' => 'Verschieb Benutzer-/Diskussionssyte mit Untersyte uf dr neij Benutzername',
	'renamewiki_usersuppress' => 'Kei Wyterleitig uf dr nej Benutzername aalege',
	'renamewiki_userreserve' => 'Blockier dr alt Benutzername fir e Neijregischtrierig',
	'renamewiki_userwarnings' => 'Warnige:',
	'renamewiki_userconfirm' => 'Jo, Benutzer umnänne',
	'renamewiki_usersubmit' => 'Umnänne',
	'renamewiki_user-submit-blocklog' => 'Benutzersperrlogbuech vo däm Benutzer aazeige',
	'renamewiki_usererrordoesnotexist' => 'Dr Benutzername „<nowiki>$1</nowiki>“ git s nit.',
	'renamewiki_usererrorexists' => 'Dr Benutzername „<nowiki>$1</nowiki>“ git s scho.',
	'renamewiki_usererrorinvalid' => 'Dr Benutzername „<nowiki>$1</nowiki>“ isch uugiltig.',
	'renamewiki_user-error-request' => 'S het e Probläm bim Empfang vu dr Aafrog gee. Bitte nomol versueche.',
	'renamewiki_user-error-same-wiki_user' => 'Dr alt und dr neij Benutzername sin identisch.',
	'renamewiki_usersuccess' => 'Dr Benutzer „<nowiki>$1</nowiki>“ isch mit Erfolg in „<nowiki>$2</nowiki>“ umgnännt wore.',
	'renamewiki_user-page-exists' => 'D Syte $1 git s scho un cha nit automatisch iberschribe wäre.',
	'renamewiki_user-page-moved' => 'D Syte $1 isch noch $2 verschobe wore.',
	'renamewiki_user-page-unmoved' => 'D Syte $1 het nit chenne noch $2 verschobe wäre.',
	'renamewiki_userlogpage' => 'Benutzernamenänderigs-Logbuech',
	'renamewiki_userlogpagetext' => 'In däm Logbuech wäre d Änderige vu Benutzernäme protokolliert.',
	'renamewiki_userlogentry' => 'het „$1“ in „$2“ umgnännt',
	'renamewiki_user-log' => '{{PLURAL:$1|1 Bearbeitig|$1 Bearbeitige}}. Grund: $2',
	'renamewiki_user-move-log' => 'dur d Umnännig vu „[[wiki_user:$1|$1]]“ noch „[[wiki_user:$2|$2]]“ automatisch verschobeni Syte',
	'action-renamewiki_user' => 'Benutzer umznänne',
	'right-renamewiki_user' => 'Benutzer umnänne',
	'renamewiki_user-renamed-notice' => 'Dää Benutzer isch umgnännt wore.
S Umnännigs-Logbuech wird do unte ufgfiert as Quälle.',
);

/** Gujarati (ગુજરાતી)
 * @author KartikMistry
 * @author Sushant savla
 */
$messages['gu'] = array(
	'renamewiki_user' => 'સભ્યનામ બદલો',
	'renamewiki_user-linkoncontribs' => 'સભ્યનામ બદલો',
	'renamewiki_user-linkoncontribs-text' => 'આ સભ્યનું નામ બદલો',
	'renamewiki_user-desc' => "સભ્યનું નામાંતરણ કરવા માટે [[Special:Renamewiki_user|special page]] ઉમેરે છે (''renamewiki_user'' હક્ક જરૂરી)",
	'renamewiki_userold' => 'હાલનું સભ્યનામ:',
	'renamewiki_usernew' => 'નવું સભ્યનામ:',
	'renamewiki_userreason' => 'નામ બદલવાનું કારણ:',
	'renamewiki_usermove' => 'સભ્ય અને ગપ્પાં પાનાંઓ (અને તેમનાં ઉપપાનાંઓ) નવાં નામ પર ખસેડો',
	'renamewiki_usersuppress' => 'નવા નામ પર દિશા નિર્દેશનો ન રચશો',
	'renamewiki_userreserve' => 'જૂના સભ્યનામને ભવિષ્યનો વપરાશ પ્રતિબંધીત કરો',
	'renamewiki_userwarnings' => 'ચેતવણીઓ:',
	'renamewiki_userconfirm' => 'હા, સભ્યનું નામ બદલો',
	'renamewiki_usersubmit' => 'જમા કરો',
	'renamewiki_user-submit-blocklog' => 'સભ્ય માટે પ્રતિબંધ લૉગ બતાવો',
	'renamewiki_usererrordoesnotexist' => 'આ સભ્ય  "<nowiki>$1</nowiki>" મોજૂદ નથી.',
	'renamewiki_usererrorexists' => 'આ સભ્ય  "<nowiki>$1</nowiki>" પહેલેથી હાજર છે.',
	'renamewiki_usererrorinvalid' => 'સભ્યનામ "<nowiki>$1</nowiki>" અયોગ્ય છે.',
	'renamewiki_user-error-request' => 'તમારી અરજી પ્રાપ્ત કરતાં કાંઈ ત્રુટી થઈ
મહેરબાની કરી ફરી પ્રયત્ન કરશો',
	'renamewiki_user-error-same-wiki_user' => 'તમે સભ્યને ફરીથી પહેલાનું નામ આપી શકશો નહી.',
	'renamewiki_usersuccess' => 'સભ્ય "<nowiki>$1</nowiki>" નું નામ બદલીને "<nowiki>$2</nowiki>" કરાયું છે.',
	'renamewiki_user-page-exists' => 'પાનું  $1 પહેલેથી અસ્તિત્વમાં છે તેના પર સ્વયંચલિત નવું લેખન ન થાય.',
	'renamewiki_user-page-moved' => 'પાના $1 ને $2 પર ખસેડાયું',
	'renamewiki_user-page-unmoved' => 'પાના $1ને $2 પર ન લઈ જઈ શકાયું',
	'renamewiki_userlogpage' => 'સભ્ય નામફેરનો લોગ',
	'renamewiki_userlogpagetext' => 'સભ્યના દ્વારા થયેલા ફેરફરની આ સંપાદન યાદિ છે .',
	'renamewiki_userlogentry' => '$1 નું નામ "$2" કર્યું',
	'renamewiki_user-log' => '{{PLURAL:$1|૧ ફેરફાર|$1 ફેરફારો}}. કારણ: $2',
	'renamewiki_user-move-log' => 'સભ્ય "[[wiki_user:$1|$1]]" થી "[[wiki_user:$2|$2]]" નામ બદલતી વખતે આપમેળે પાનું ખસેડ્યું',
	'action-renamewiki_user' => 'સભ્યોનાં નામ બદલો',
	'right-renamewiki_user' => 'સભ્યોના નામ બદલો',
	'renamewiki_user-renamed-notice' => 'આ સભ્યનું નામ પરિવર્તન થયું છે.
નામ પરિવર્તન લોગ તમારા સંદર્ભ માટે અહીં આપેલ છે',
);

/** Hebrew (עברית)
 * @author Amire80
 * @author Ofekalef
 * @author Rotem Liss
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'renamewiki_user' => 'שינוי שם משתמש',
	'renamewiki_user-linkoncontribs' => 'שינוי שם משתמש',
	'renamewiki_user-linkoncontribs-text' => 'שינוי שם המשתמש הזה',
	'renamewiki_user-desc' => "הוספת [[Special:Renamewiki_user|דף מיוחד]] לשינוי שם משתמש (דרושה הרשאת ''renamewiki_user'')",
	'renamewiki_userold' => 'שם משתמש נוכחי:',
	'renamewiki_usernew' => 'שם משתמש חדש:',
	'renamewiki_userreason' => 'סיבה לשינוי השם:',
	'renamewiki_usermove' => 'העברת דפי המשתמש והשיחה (כולל דפי המשנה שלהם) לשם החדש',
	'renamewiki_usersuppress' => 'לא ליצור הפניות לשם החדש',
	'renamewiki_userreserve' => 'חסימת שם המשתמש הישן לשימוש נוסף',
	'renamewiki_userwarnings' => 'אזהרות:',
	'renamewiki_userconfirm' => 'כן, לשנות את שם המשתמש',
	'renamewiki_usersubmit' => 'שינוי שם משתמש',
	'renamewiki_user-submit-blocklog' => 'הצגת יומן החסימות של המשתמש',
	'renamewiki_usererrordoesnotexist' => 'המשתמש "<nowiki>$1</nowiki>" אינו קיים.',
	'renamewiki_usererrorexists' => 'המשתמש "<nowiki>$1</nowiki>" כבר קיים.',
	'renamewiki_usererrorinvalid' => 'שם המשתמש "<nowiki>$1</nowiki>" אינו תקין.',
	'renamewiki_user-error-request' => 'הייתה בעיה בקבלת הבקשה. אנא חזרו לדף הקודם ונסו שנית.',
	'renamewiki_user-error-same-wiki_user' => 'אינכם יכולים לשנות את שם המשתמש לשם זהה לשמו הישן.',
	'renamewiki_usersuccess' => 'שם המשתמש של "<nowiki>$1</nowiki>" שונה ל"<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'הדף $1 כבר קיים ולא ניתן לדרוס אותו אוטומטית.',
	'renamewiki_user-page-moved' => 'הדף $1 הועבר לשם $2.',
	'renamewiki_user-page-unmoved' => 'לא ניתן היה להעביר את הדף $1 ל$2.',
	'renamewiki_userlogpage' => 'יומן שינויי שמות משתמש',
	'renamewiki_userlogpagetext' => 'זהו יומן השינויים בשמות המשתמשים.',
	'renamewiki_userlogentry' => 'שינה את שם המשתמש "$1" ל־"$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|עריכה אחת|$1 עריכות}}. סיבה: $2',
	'renamewiki_user-move-log' => 'העברה אוטומטית בעקבות שינוי שם המשתמש "[[wiki_user:$1|$1]]" ל־"[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'לשנות שמות משתמש',
	'right-renamewiki_user' => 'שינוי שמות משתמש',
	'renamewiki_user-renamed-notice' => 'שם המשתמש הזה שונה.
יומן שינויי שמות המשתמש מוצג להלן.',
);

/** Hindi (हिन्दी)
 * @author Ansumang
 * @author Kaustubh
 */
$messages['hi'] = array(
	'renamewiki_user' => 'सदस्यनाम बदलें',
	'renamewiki_user-linkoncontribs' => 'सदस्यनाम बदलें',
	'renamewiki_user-linkoncontribs-text' => 'इस सदस्य के नाम बदलें',
	'renamewiki_user-desc' => "सदस्यनाम बदलें (''सदस्यनाम बदलने अधिकार'' अनिवार्य)",
	'renamewiki_userold' => 'सद्य सदस्यनाम:',
	'renamewiki_usernew' => 'नया सदस्यनाम:',
	'renamewiki_userreason' => 'नाम बदलने के कारण:',
	'renamewiki_usermove' => 'सदस्य पृष्ठ और वार्ता पृष्ठ (और उनके सबपेज) नये नाम की ओर भेजें',
	'renamewiki_usersuppress' => 'नूतन नाम को अनुप्रेषित ना करें',
	'renamewiki_userreserve' => 'पुरानी सदस्यनाम को अवरोध करें',
	'renamewiki_userwarnings' => 'चेतावनी:',
	'renamewiki_userconfirm' => 'हाँ, सदस्य के नाम बदलें',
	'renamewiki_usersubmit' => 'भेजें',
	'renamewiki_usererrordoesnotexist' => 'सदस्य "<nowiki>$1</nowiki>" अस्तित्वमें नहीं हैं।',
	'renamewiki_usererrorexists' => 'सदस्य "<nowiki>$1</nowiki>" पहले से अस्तित्वमें हैं।',
	'renamewiki_usererrorinvalid' => 'सदस्यनाम "<nowiki>$1</nowiki>" गलत हैं।',
	'renamewiki_user-error-request' => 'यह मांग पूरी करने मे समस्या आई हैं।
कृपया पीछे जाकर फिरसे यत्न करें।',
	'renamewiki_user-error-same-wiki_user' => 'आप सदस्यनाम को उसी नामसे बदल नहीं सकते हैं।',
	'renamewiki_usersuccess' => '"<nowiki>$1</nowiki>" का सदस्यनाम "<nowiki>$2</nowiki>" कर दिया गया हैं।',
	'renamewiki_user-page-exists' => '$1 यह पन्ना पहले से अस्तित्वमें हैं और इसपर अपने आप पुनर्लेखन नहीं कर सकतें।',
	'renamewiki_user-page-moved' => '$1 का नाम बदलकर $2 कर दिया गया हैं।',
	'renamewiki_user-page-unmoved' => '$1 का नाम बदलकर $2 नहीं कर सकें हैं।',
	'renamewiki_userlogpage' => 'सदस्यनाम बदलाव सूची',
	'renamewiki_userlogpagetext' => 'यह सदस्यनामोंमें हुए बदलावोंकी सूची हैं',
	'renamewiki_userlogentry' => 'ने $1 को "$2" में बदल दिया हैं',
	'renamewiki_user-log' => '{{PLURAL:$1|1 बदलाव|$1 बदलाव}}. कारण: $2',
	'renamewiki_user-move-log' => '"[[wiki_user:$1|$1]]" को "[[wiki_user:$2|$2]]" करते वक्त अपने आप सदस्यपृष्ठ बदल दिया हैं',
	'right-renamewiki_user' => 'सदस्योंके नाम बदलें',
	'renamewiki_user-renamed-notice' => 'इस सदस्य का नाम बदल दिया गया है।
संदर्भ के लिए नीचे नाम बदलने का चिट्ठा है।',
);

/** Fiji Hindi (Latin script) (Fiji Hindi)
 * @author Thakurji
 */
$messages['hif-latn'] = array(
	'renamewiki_user' => 'Sadasya ke naam badlo',
	'renamewiki_user-desc' => "[[Special:Renamewiki_user|special panna]] ke jorro ek sadasya  ke naam badle ke khatir (''renamewiki_user'' ke hak maange hai)",
	'renamewiki_userold' => 'Abhi ke wiki_username:',
	'renamewiki_usernew' => 'Nawaa wiki_username:',
	'renamewiki_userreason' => 'Naam badle ke kaaran:',
	'renamewiki_usermove' => 'Sadasya aur salah waala panna (aur uske sub-panna) ke naam badlo',
	'renamewiki_userreserve' => 'Purana wiki_username ke aage use kare se roko',
	'renamewiki_userwarnings' => 'Chetauni:',
	'renamewiki_userconfirm' => 'Haan, sadasya ke naam badlo',
	'renamewiki_usersubmit' => 'Submit karo',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" naam ke koi sadasya nai hai.',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" naam ke ek sadasya abhi hai.',
	'renamewiki_usererrorinvalid' => 'wiki_username "<nowiki>$1</nowiki>" kharaab hai.',
	'renamewiki_user-error-request' => 'Request ke le me kuchh karrbarr bhais hai.
Meharbani kar ke laut ke fir kosis karo.',
	'renamewiki_user-error-same-wiki_user' => 'Aap sadasya ke naam ke badal ke pahile waala naam nai kare sakta hai.',
	'renamewiki_usersuccess' => 'Sadasya "<nowiki>$1</nowiki>" ke naam badal ke "<nowiki>$2</nowiki>" kar dewa gais hai.',
	'renamewiki_user-page-exists' => 'Panna $1 abhi hai aur iske apne se overwrite nai karaa jaae sake hai.',
	'renamewiki_user-page-moved' => 'Panna $1 ke naam badal ke $2 kar dewa gais hai.',
	'renamewiki_user-page-unmoved' => 'Panna $1 ke naam badal ke $2 nai kare sakaa hai.',
	'renamewiki_userlogpage' => 'Sadasya ke naam badle ke log',
	'renamewiki_userlogpagetext' => 'Ii ek sadasya ke naam badle ke log hai.',
	'renamewiki_userlogentry' => '$1 ke naam badal ke "$2" kar dewa gais hai',
	'renamewiki_user-log' => '{{PLURAL:$1|1 badlao|$1 badlao}}. Kaaran: $2',
	'renamewiki_user-move-log' => 'Automatically panna ke move kar diya hai jab ki sadasya ke naam  "[[wiki_user:$1|$1]]" se badal ke "[[wiki_user:$2|$2]]" kar dewa gais hai',
	'right-renamewiki_user' => 'Sadasya log ke naam badlo',
);

/** Croatian (hrvatski)
 * @author Dalibor Bosits
 * @author Dnik
 * @author Ex13
 * @author SpeedyGonsales
 * @author Tivek
 */
$messages['hr'] = array(
	'renamewiki_user' => 'Preimenuj suradnika',
	'renamewiki_user-linkoncontribs' => 'preimenuj suradnika',
	'renamewiki_user-linkoncontribs-text' => 'Preimenuj ovog suradnika',
	'renamewiki_user-desc' => "Dodaje [[Special:Renamewiki_user|posebnu stranicu]] za preimenovanje suradnika (potrebno je ''renamewiki_user'' pravo)",
	'renamewiki_userold' => 'Trenutačno suradničko ime:',
	'renamewiki_usernew' => 'Novo suradničko ime:',
	'renamewiki_userreason' => 'Razlog za preimenovanje:',
	'renamewiki_usermove' => 'Premjesti suradnikove stranice (glavnu, stranicu za razgovor i podstranice, ako postoje) na novo ime',
	'renamewiki_usersuppress' => 'Ne kreiraj preusmjeravanja na novo ime',
	'renamewiki_userreserve' => 'Zadrži staro suradničko ime od daljnje upotrebe',
	'renamewiki_userwarnings' => 'Upozorenja:',
	'renamewiki_userconfirm' => 'Da, preimenuj suradnika',
	'renamewiki_usersubmit' => 'Potvrdi',
	'renamewiki_usererrordoesnotexist' => 'Suradnik "<nowiki>$1</nowiki>" ne postoji (suradničko ime nije zauzeto).',
	'renamewiki_usererrorexists' => 'Suradničko ime "<nowiki>$1</nowiki>" već postoji',
	'renamewiki_usererrorinvalid' => 'Suradničko ime "<nowiki>$1</nowiki>" nije valjano',
	'renamewiki_user-error-request' => 'Pojavio se problem sa zaprimanjem zahtjeva. Molimo, vratite se i probajte ponovo.',
	'renamewiki_user-error-same-wiki_user' => 'Ne možete preimenovati suradnika u isto kao prethodno.',
	'renamewiki_usersuccess' => 'Suradnik "<nowiki>$1</nowiki>" je preimenovan u "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'Stranica $1 već postoji i ne može biti prepisana.',
	'renamewiki_user-page-moved' => 'Suradnikova stranica $1 je premještena, sad se zove: $2.',
	'renamewiki_user-page-unmoved' => 'Stranica $1 ne može biti preimenovana u $2.',
	'renamewiki_userlogpage' => 'Evidencija preimenovanja suradnika',
	'renamewiki_userlogpagetext' => 'Ovo je evidencija preimenovanja suradničkih imena',
	'renamewiki_userlogentry' => 'promijenjeno suradničko ime $1 u "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 uređivanje|$1 uređivanja}}. Razlog: $2',
	'renamewiki_user-move-log' => 'Stranica suradnika je premještena prilikom preimenovanja iz "[[wiki_user:$1|$1]]" u "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'Preimenovati suradnike',
	'renamewiki_user-renamed-notice' => 'Ovaj suradnik je preimenovan.
Evidencija preimenovanja suradnika je prikazana ispod kao obavijest.',
);

/** Upper Sorbian (hornjoserbsce)
 * @author Dundak
 * @author Michawiki
 */
$messages['hsb'] = array(
	'renamewiki_user' => 'Wužiwarja přemjenować',
	'renamewiki_user-linkoncontribs' => 'wužiwarja přemjenować',
	'renamewiki_user-linkoncontribs-text' => 'Tutoho wužiwarja přemjenować',
	'renamewiki_user-desc' => "Wužiwarja přemjenować (požada prawo ''renamewiki_user'')",
	'renamewiki_userold' => 'Tuchwilne wužiwarske mjeno:',
	'renamewiki_usernew' => 'Nowe wužiwarske mjeno:',
	'renamewiki_userreason' => 'Přičina za přemjenowanje:',
	'renamewiki_usermove' => 'Wužiwarsku stronu a wužiwarsku diskusiju (a jeju podstrony) na nowe mjeno přesunyć',
	'renamewiki_usersuppress' => 'Dalesposrědkowanja k nowemu mjenu njewutworić',
	'renamewiki_userreserve' => 'Stare wužiwarske mjeno za přichodne wužiwanje blokować',
	'renamewiki_userwarnings' => 'Warnowanja:',
	'renamewiki_userconfirm' => 'Haj, wužiwarja přemjenować',
	'renamewiki_usersubmit' => 'Składować',
	'renamewiki_user-submit-blocklog' => 'Blokowanski protokol za wužiwarja pokazać',
	'renamewiki_usererrordoesnotexist' => 'Wužiwarske mjeno „<nowiki>$1</nowiki>“ njeeksistuje.',
	'renamewiki_usererrorexists' => 'Wužiwarske mjeno „<nowiki>$1</nowiki>“ hižo eksistuje.',
	'renamewiki_usererrorinvalid' => 'Wužiwarske mjeno „<nowiki>$1</nowiki>“ njeje płaćiwe.',
	'renamewiki_user-error-request' => 'Problem je při přijimanju požadanja wustupił. Prošu dźi wróćo a spytaj hišće raz.',
	'renamewiki_user-error-same-wiki_user' => 'Njemóžeš wužiwarja do samsneje wěcy kaž prjedy přemjenować.',
	'renamewiki_usersuccess' => 'Wužiwar „<nowiki>$1</nowiki>“ bu wuspěšnje na „<nowiki>$2</nowiki>“ přemjenowany.',
	'renamewiki_user-page-exists' => 'Strona $1 hižo eksistuje a njemóže so awtomatisce přepisować.',
	'renamewiki_user-page-moved' => 'Strona $1 bu pod nowy titul $2 přesunjena.',
	'renamewiki_user-page-unmoved' => 'Njemóžno stronu $1 pod titul $2 přesunyć.',
	'renamewiki_userlogpage' => 'Protokol přemjenowanja wužiwarjow',
	'renamewiki_userlogpagetext' => 'Tu protokoluja so wšě přemjenowanja wužiwarjow.',
	'renamewiki_userlogentry' => 'je $1 do "$2" přemjenował',
	'renamewiki_user-log' => '{{PLURAL:$1|1 změna|$1 změnje|$1 změny|$1 změnow}}. Přičina: $2',
	'renamewiki_user-move-log' => 'Přez přemjenowanje wužiwarja „[[wiki_user:$1|$1]]“ na „[[wiki_user:$2|$2]]“ awtomatisce přesunjena strona.',
	'action-renamewiki_user' => 'wužiwarjow přemjenować',
	'right-renamewiki_user' => 'Wužiwarjow přemjenować',
	'renamewiki_user-renamed-notice' => 'Tutón wužiwar je so přemjenował.
Protokol přemjenowanjow je deleka jako referenca podaty.',
);

/** Hungarian (magyar)
 * @author Adam78
 * @author Dani
 * @author Dj
 * @author Tgr
 */
$messages['hu'] = array(
	'renamewiki_user' => 'Szerkesztő átnevezése',
	'renamewiki_user-linkoncontribs' => 'felhasználó átnevezése',
	'renamewiki_user-linkoncontribs-text' => 'Felhasználó átnevezése',
	'renamewiki_user-desc' => "Lehetővé teszi egy felhasználó átnevezését (''renamewiki_user'' jog szükséges)",
	'renamewiki_userold' => 'Jelenlegi felhasználónév:',
	'renamewiki_usernew' => 'Új felhasználónév:',
	'renamewiki_userreason' => 'Átnevezés oka:',
	'renamewiki_usermove' => 'Felhasználói- és vitalapok (és azok allapjainak) áthelyezése az új név alá',
	'renamewiki_usersuppress' => 'Ne készüljön átirányítás az új névre',
	'renamewiki_userreserve' => 'Régi név blokkolása a jövőbeli használat megakadályozására',
	'renamewiki_userwarnings' => 'Figyelmeztetések:',
	'renamewiki_userconfirm' => 'Igen, nevezd át a szerkesztőt',
	'renamewiki_usersubmit' => 'Elküld',
	'renamewiki_usererrordoesnotexist' => 'Nem létezik „<nowiki>$1</nowiki>” nevű felhasználó',
	'renamewiki_usererrorexists' => 'Már létezik „<nowiki>$1</nowiki>” nevű felhasználó',
	'renamewiki_usererrorinvalid' => 'A felhasználónév („<nowiki>$1</nowiki>”) érvénytelen',
	'renamewiki_user-error-request' => 'Hiba történt a lekérdezés küldése közben.  Menj vissza az előző oldalra és próbáld újra.',
	'renamewiki_user-error-same-wiki_user' => 'Nem nevezhetsz át egy felhasználót a meglévő nevére.',
	'renamewiki_usersuccess' => '„<nowiki>$1</nowiki>” sikeresen át lett nevezve „<nowiki>$2</nowiki>” névre.',
	'renamewiki_user-page-exists' => '$1 már létezik, és nem lehet automatikusan felülírni.',
	'renamewiki_user-page-moved' => '$1 át lett nevezve $2 névre',
	'renamewiki_user-page-unmoved' => '$1-t nem sikerült $2 névre nevezi',
	'renamewiki_userlogpage' => 'Felhasználóátnevezési napló',
	'renamewiki_userlogpagetext' => 'Ez a felhasználói nevek változtatásának naplója.',
	'renamewiki_userlogentry' => 'átnevezte $1 azonosítóját (az új név: „$2”)',
	'renamewiki_user-log' => '$1 szerkesztése van. Indoklás: $2',
	'renamewiki_user-move-log' => '„[[wiki_user:$1|$1]]” „[[wiki_user:$2|$2]]” névre való átnevezése közben automatikusan átnevezett oldal',
	'action-renamewiki_user' => 'felhasználó átnevezése',
	'right-renamewiki_user' => 'felhasználók átnevezése',
	'renamewiki_user-renamed-notice' => 'Ezt a szerkesztőt átnevezték.
Alább látható a szerkesztőátnevezési napló tájékoztatásként.',
);

/** Interlingua (interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'renamewiki_user' => 'Renominar usator',
	'renamewiki_user-linkoncontribs' => 'renominar usator',
	'renamewiki_user-linkoncontribs-text' => 'Renominar iste usator',
	'renamewiki_user-desc' => "Adde un [[Special:Renamewiki_user|pagina special]] pro renominar un usator (require le privilegio ''renamewiki_user'')",
	'renamewiki_userold' => 'Nomine de usator actual:',
	'renamewiki_usernew' => 'Nove nomine de usator:',
	'renamewiki_userreason' => 'Motivo del renomination:',
	'renamewiki_usermove' => 'Renominar etiam le paginas de usator e de discussion (e lor subpaginas) verso le nove nomine',
	'renamewiki_usersuppress' => 'Non crear redirectiones al nove nomine',
	'renamewiki_userreserve' => 'Blocar le ancian nomine de usator de esser usate in le futuro',
	'renamewiki_userwarnings' => 'Advertimentos:',
	'renamewiki_userconfirm' => 'Si, renomina le usator',
	'renamewiki_usersubmit' => 'Submitter',
	'renamewiki_user-submit-blocklog' => 'Monstrar registro de blocadas pro le usator',
	'renamewiki_usererrordoesnotexist' => 'Le usator "<nowiki>$1</nowiki>" non existe.',
	'renamewiki_usererrorexists' => 'Le usator ""<nowiki>$1</nowiki>"" existe ja.',
	'renamewiki_usererrorinvalid' => 'Le nomine de usator "<nowiki>$1</nowiki>" es invalide.',
	'renamewiki_user-error-request' => 'Il habeva un problema con le reception del requesta.
Per favor retorna e reproba.',
	'renamewiki_user-error-same-wiki_user' => 'Tu non pote renominar un usator al mesme nomine.',
	'renamewiki_usersuccess' => 'Le usator "<nowiki>$1</nowiki>" ha essite renominate a "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Le pagina $1 existe ja e non pote esser automaticamente superscribite.',
	'renamewiki_user-page-moved' => 'Le pagina $1 ha essite renominate a $2.',
	'renamewiki_user-page-unmoved' => 'Le pagina $1 non poteva esser renominate a $2.',
	'renamewiki_userlogpage' => 'Registro de renominationes de usatores',
	'renamewiki_userlogpagetext' => 'Isto es un registro de cambiamentos de nomines de usator.',
	'renamewiki_userlogentry' => 'renominava $1 verso "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 modification|$1 modificationes}}. Motivo: $2',
	'renamewiki_user-move-log' => 'Le pagina ha essite automaticamente renominate con le renomination del usator "[[wiki_user:$1|$1]]" a "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'renominar usatores',
	'right-renamewiki_user' => 'Renominar usatores',
	'renamewiki_user-renamed-notice' => 'Iste usator ha essite renominate.
Le registro de renominationes es providite ci infra pro referentia.',
);

/** Indonesian (Bahasa Indonesia)
 * @author Bennylin
 * @author Farras
 * @author Irwangatot
 * @author IvanLanin
 * @author Rex
 */
$messages['id'] = array(
	'renamewiki_user' => 'Penggantian nama pengguna',
	'renamewiki_user-linkoncontribs' => 'mengubah nama pengguna',
	'renamewiki_user-linkoncontribs-text' => 'Ubah nama pengguna ini',
	'renamewiki_user-desc' => "Mengganti nama pengguna (perlu hak akses ''renamewiki_user'')",
	'renamewiki_userold' => 'Nama sekarang:',
	'renamewiki_usernew' => 'Nama baru:',
	'renamewiki_userreason' => 'Alasan penggantian nama:',
	'renamewiki_usermove' => 'Pindahkan halaman pengguna dan pembicaraannya (berikut subhalamannya) ke nama baru',
	'renamewiki_usersuppress' => 'Jangan membuat pengalihan untuk nama baru',
	'renamewiki_userreserve' => 'Cadangkan nama pengguna lama sehingga tidak dapat digunakan lagi',
	'renamewiki_userwarnings' => 'Peringatan:',
	'renamewiki_userconfirm' => 'Ya, ganti nama pengguna tersebut',
	'renamewiki_usersubmit' => 'Kirim',
	'renamewiki_user-submit-blocklog' => 'Tampilkan log pemblokiran pengguna',
	'renamewiki_usererrordoesnotexist' => 'Pengguna "<nowiki>$1</nowiki>" tidak ada',
	'renamewiki_usererrorexists' => 'Pengguna "<nowiki>$1</nowiki>" telah ada',
	'renamewiki_usererrorinvalid' => 'Nama pengguna "<nowiki>$1</nowiki>" tidak sah',
	'renamewiki_user-error-request' => 'Ada masalah dalam pemrosesan permintaan. Silakan kembali dan coba lagi.',
	'renamewiki_user-error-same-wiki_user' => 'Anda tak dapat mengganti nama pengguna sama seperti asalnya.',
	'renamewiki_usersuccess' => 'Pengguna "<nowiki>$1</nowiki>" telah diganti namanya menjadi "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'Halaman $1 telah ada dan tidak dapat ditimpa secara otomatis.',
	'renamewiki_user-page-moved' => 'Halaman $1 telah dipindah ke $2.',
	'renamewiki_user-page-unmoved' => 'Halaman $1 tidak dapat dipindah ke $2.',
	'renamewiki_userlogpage' => 'Log penggantian nama pengguna',
	'renamewiki_userlogpagetext' => 'Di bawah ini adalah log penggantian nama pengguna',
	'renamewiki_userlogentry' => 'telah mengganti nama $1 menjadi "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 suntingan|$1 suntingan}}. Alasan: $2',
	'renamewiki_user-move-log' => 'Secara otomatis memindahkan halaman sewaktu mengganti nama pengguna "[[wiki_user:$1|$1]]" menjadi "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'ganti nama pengguna',
	'right-renamewiki_user' => 'Mengganti nama pengguna',
	'renamewiki_user-renamed-notice' => 'Penguna ini telah berganti nama.
Log pergantian nama disediakan di bawah untuk referensi.',
);

/** Igbo (Igbo)
 * @author Ukabia
 */
$messages['ig'] = array(
	'renamewiki_userwarnings' => 'Ngéntị:',
	'renamewiki_usersubmit' => 'Dànyé',
	'renamewiki_user-page-moved' => 'Ihü $1 a páfùrù gá $2.',
	'renamewiki_user-page-unmoved' => 'Ihü $1 énweghịkị páfù gá $2.',
);

/** Iloko (Ilokano)
 * @author Lam-ang
 */
$messages['ilo'] = array(
	'renamewiki_user' => 'Inaganan manen ti agar-aramat',
	'renamewiki_user-linkoncontribs' => 'inaganan manen ti agar-aramat',
	'renamewiki_user-linkoncontribs-text' => 'Inaganan manen daytoy nga agar-aramat',
	'renamewiki_user-desc' => "Agnayon ti [[Special:Renamewiki_user|espesial a panid]] tapno inaganan manen ti agar-aramat (masapul ti ''inaganan manen ti agar-aramat'' a karbengan)",
	'renamewiki_userold' => 'Agdama a nagan ti agar-aramat:',
	'renamewiki_usernew' => 'Baro a nagan ti agar-aramat:',
	'renamewiki_userreason' => 'Rason ti panaginagan manen:',
	'renamewiki_usermove' => 'Iyalis ti agar-aramat ket tungtungan a pampanid (ken dagiti ap-apo a panid) iti baro a nagan',
	'renamewiki_usersuppress' => 'Saan nga agpartuat kadagiti baw-ing idiay baro a nagan',
	'renamewiki_userreserve' => 'Serraan ti daan a nagan ti agar-aramat manipud ti masakbayan a panag-usar.',
	'renamewiki_userwarnings' => 'Dagiti ballaag:',
	'renamewiki_userconfirm' => 'Wen, inaganan manen ti agar-aramat',
	'renamewiki_usersubmit' => 'Ited',
	'renamewiki_user-submit-blocklog' => 'Ipakita ti panakaserra a listaan para iti agar-aramat',
	'renamewiki_usererrordoesnotexist' => 'Ti agar-aramat "<nowiki>$1</nowiki>" ket awan.',
	'renamewiki_usererrorexists' => 'Ti agar-aramat "<nowiki>$1</nowiki>" ket addan.',
	'renamewiki_usererrorinvalid' => 'Ti nagan ti agar-aramat "<nowiki>$1</nowiki>" ket imbalido.',
	'renamewiki_user-error-request' => 'Adda pakirut ti panakaawat ti kiddaw.
Pangngaasi nga agsubli ken padasen manen.',
	'renamewiki_user-error-same-wiki_user' => 'Saanmo a mainaganan manen ti agar-aramat a kas idi.',
	'renamewiki_usersuccess' => 'Ti agar-aramat "<nowiki>$1</nowiki>" ket nainaganan manen ti "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Ti panid a $1 ket addaan ken saan a mautomatiko a suratan manen.',
	'renamewiki_user-page-moved' => 'Ti panid $1 ket naiyalisen idiay $2.',
	'renamewiki_user-page-unmoved' => 'Ti panid  $1 ket saan a maiyalis idiay $2.',
	'renamewiki_userlogpage' => 'Listaan ti panaginaganan manen ti agar-aramat',
	'renamewiki_userlogpagetext' => 'Listaan daytoy kadagiti sinukatan a nag-nagan ti agararamat.',
	'renamewiki_userlogentry' => 'ninaganan manen ti $1 iti "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 urnos|$1 ur-urnos}}. Rason: $2',
	'renamewiki_user-move-log' => 'Automatiko nga iyalis ti panid bayat a nagnaganan manen ti agar-aramat "[[wiki_user:$1|$1]]" iti "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'inaganan manen dagiti agar-aramat',
	'right-renamewiki_user' => 'Inaganan manen dagiti agar-aramat',
	'renamewiki_user-renamed-notice' => 'Nanaganen manen daytoy nga agar-aramat.
Ti listaan ti panaginaganan manen ket naited dita baba para iti reperensia.',
);

/** Ido (Ido)
 * @author Malafaya
 * @author Wyvernoid
 */
$messages['io'] = array(
	'renamewiki_user' => 'Rinomar uzanto',
	'renamewiki_userold' => 'Aktuala uzantonomo:',
	'renamewiki_usernew' => 'Nova uzantonomo:',
	'renamewiki_userwarnings' => 'Averti:',
	'renamewiki_userconfirm' => "Yes, rinomez l'uzanto",
	'renamewiki_usererrordoesnotexist' => 'L\'uzanto "<nowiki>$1</nowiki>" ne existas.',
	'renamewiki_usererrorexists' => 'L\'uzanto "<nowiki>$1</nowiki>" ja existas.',
	'renamewiki_usererrorinvalid' => 'L\'uzantonomo "<nowiki>$1</nowiki>" esas ne-valida.',
	'renamewiki_user-error-same-wiki_user' => 'Vu ne povas renomar uzanto ad la sama nomo.',
	'renamewiki_usersuccess' => 'La uzanto "<nowiki>$1</nowiki>" rinomesis "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-moved' => 'La pagino $1 movesis a $2.',
	'renamewiki_user-page-unmoved' => 'On ne povis movar la pagino $1 a $2.',
	'renamewiki_userlogpage' => 'Registro di uzanto-rinomizuri',
	'renamewiki_userlogpagetext' => 'Ito es registro di uzantonomala chanji.',
	'renamewiki_userlogentry' => 'rinomis $1 por "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 redakto|$1 redakti}}. Motivo: $2',
	'right-renamewiki_user' => 'Rinomar uzanti',
);

/** Icelandic (íslenska)
 * @author Cessator
 * @author S.Örvarr.S
 * @author Snævar
 * @author Spacebirdy
 * @author Ævar Arnfjörð Bjarmason
 * @author לערי ריינהארט
 */
$messages['is'] = array(
	'renamewiki_user' => 'Breyta notandanafni',
	'renamewiki_user-linkoncontribs' => 'breyta notendanafni',
	'renamewiki_user-linkoncontribs-text' => 'breyta notendanafni notandans',
	'renamewiki_user-desc' => "Bætir við [[Special:Renamewiki_user|kerfissíðu]] til að breyta notendanafni (þarfnast ''renamewiki_user'' réttinda)",
	'renamewiki_userold' => 'Núverandi notandanafn:',
	'renamewiki_usernew' => 'Nýja notandanafnið:',
	'renamewiki_userreason' => 'Ástæða:',
	'renamewiki_usermove' => 'Færa notendasíðu og notendaspjallsíðu (og undirsíður þeirra) á nýja nafnið',
	'renamewiki_usersuppress' => 'Ekki skilja eftir tilvísun',
	'renamewiki_userreserve' => 'Banna notkun á gamla notendanafninu',
	'renamewiki_userwarnings' => 'Viðvaranir:',
	'renamewiki_userconfirm' => 'Já, breyta nafni notandans',
	'renamewiki_usersubmit' => 'Senda',
	'renamewiki_user-submit-blocklog' => 'Sýna bönnunar skrá notandans',
	'renamewiki_usererrordoesnotexist' => 'Notandinn „<nowiki>$1</nowiki>“ er ekki til',
	'renamewiki_usererrorexists' => 'Notandinn „<nowiki>$1</nowiki>“ er nú þegar til',
	'renamewiki_usererrorinvalid' => 'Notandanafnið „<nowiki>$1</nowiki>“ er ógilt',
	'renamewiki_user-error-request' => 'Mistókst að sækja beiðnina um breytingu notendanafnsins.
Vinsamlegast farðu til baka og reyndu aftur.',
	'renamewiki_user-error-same-wiki_user' => 'Óheimilt er að breyta nafni notanda aftur á það notendanafn sem hann hafði áður.',
	'renamewiki_usersuccess' => 'Nafn notandans "<nowiki>$1</nowiki>" hefur verið breytt í "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Síða sem heitir $1 er nú þegar til og það er ekki hægt að búa til nýja grein með sama heiti.',
	'renamewiki_user-page-moved' => 'Síðan $1 hefur verið færð á $2.',
	'renamewiki_user-page-unmoved' => 'Ekki var hægt að færa síðuna $1 á $2.',
	'renamewiki_userlogpage' => 'Skrá yfir nafnabreytingar notenda',
	'renamewiki_userlogpagetext' => 'Þetta er skrá yfir nýlegar breytingar á notendanöfnum.',
	'renamewiki_userlogentry' => 'breytti nafni $1 í "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 breyting|$1 breytingar}}. Ástæða: $2',
	'renamewiki_user-move-log' => 'Færði síðuna sjálfvirkt þegar notendanafni "[[wiki_user:$1|$1]]" var breytt í "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'endurnefna notendur',
	'right-renamewiki_user' => 'Breyta notandanafni notenda',
	'renamewiki_user-renamed-notice' => 'Nafni notandans hefur verið breytt. 
Síðasta færsla notandans úr skrá yfir nafnabreytingar notenda er sýnd hér fyrir neðan til skýringar:',
);

/** Italian (italiano)
 * @author .anaconda
 * @author Beta16
 * @author BrokenArrow
 * @author Darth Kule
 * @author Gianfranco
 * @author HalphaZ
 * @author Melos
 * @author Nemo bis
 */
$messages['it'] = array(
	'renamewiki_user' => 'Rinomina utente',
	'renamewiki_user-linkoncontribs' => 'rinomina utente',
	'renamewiki_user-linkoncontribs-text' => 'Rinomina questo utente',
	'renamewiki_user-desc' => "Aggiunge una [[Special:Renamewiki_user|pagina speciale]] per rinominare un utente (richiede i diritti di ''renamewiki_user'')",
	'renamewiki_userold' => 'Nome utente attuale:',
	'renamewiki_usernew' => 'Nuovo nome utente:',
	'renamewiki_userreason' => 'Motivo del cambio nome:',
	'renamewiki_usermove' => 'Rinomina anche la pagina utente, la pagina di discussione e le relative sottopagine',
	'renamewiki_usersuppress' => 'Non creare redirect al nuovo nome',
	'renamewiki_userreserve' => "Impedisci l'utilizzo del vecchio nome in futuro",
	'renamewiki_userwarnings' => 'Avvisi:',
	'renamewiki_userconfirm' => 'Sì, rinomina questo utente',
	'renamewiki_usersubmit' => 'Invia',
	'renamewiki_user-submit-blocklog' => "Mostra registro dei blocchi per l'utente",
	'renamewiki_usererrordoesnotexist' => 'L\'utente "<nowiki>$1</nowiki>" non esiste.',
	'renamewiki_usererrorexists' => 'L\'utente "<nowiki>$1</nowiki>" esiste già.',
	'renamewiki_usererrorinvalid' => 'Il nome utente "<nowiki>$1</nowiki>" non è valido',
	'renamewiki_user-error-request' => 'Si è verificato un problema nella ricezione della richiesta. Tornare indietro e riprovare.',
	'renamewiki_user-error-same-wiki_user' => 'Non è possibile rinominare un utente allo stesso nome che aveva già.',
	'renamewiki_usersuccess' => 'L\'utente "<nowiki>$1</nowiki>" è stato rinominato in "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'La pagina $1 esiste già; impossibile sovrascriverla automaticamente.',
	'renamewiki_user-page-moved' => 'La pagina $1 è stata spostata a $2.',
	'renamewiki_user-page-unmoved' => 'La pagina $1 non può essere spostata a $2.',
	'renamewiki_userlogpage' => 'Utenti rinominati',
	'renamewiki_userlogpagetext' => 'Di seguito sono elencate le modifiche ai nomi utente.',
	'renamewiki_userlogentry' => 'ha rinominato $1 in "$2"',
	'renamewiki_user-log' => 'Che ha {{PLURAL:$1|un contributo|$1 contributi}}. Motivo: $2',
	'renamewiki_user-move-log' => 'Pagina spostata automaticamente durante la rinomina dell\'utente "[[wiki_user:$1|$1]]" a "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'rinominare gli utenti',
	'right-renamewiki_user' => 'Rinomina gli utenti',
	'renamewiki_user-renamed-notice' => 'Questo utente è stato rinominato.
Il registro delle rinomine è riportato di seguito per informazione.',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Broad-Sky
 * @author Fryed-peach
 * @author Hosiryuhosi
 * @author Marine-Blue
 * @author Ohgi
 * @author Penn Station
 * @author Shirayuki
 * @author Suisui
 * @author 青子守歌
 */
$messages['ja'] = array(
	'renamewiki_user' => '利用者名の変更',
	'renamewiki_user-linkoncontribs' => '利用者名変更',
	'renamewiki_user-linkoncontribs-text' => 'この利用者の名前を変更',
	'renamewiki_user-desc' => '利用者名変更のための[[Special:Renamewiki_user|特別ページ]]を追加する(renamewiki_user権限が必要)',
	'renamewiki_userold' => '現在の利用者名:',
	'renamewiki_usernew' => '新しい利用者名:',
	'renamewiki_userreason' => '変更理由:',
	'renamewiki_usermove' => '利用者ページと会話ページ（およびそれらの下位ページ）を新しい名前に移動',
	'renamewiki_usersuppress' => '新しい名前へのリダイレクトを作成しない',
	'renamewiki_userreserve' => '旧利用者名の今後の使用をブロック',
	'renamewiki_userwarnings' => '警告:',
	'renamewiki_userconfirm' => 'はい、利用者名を変更します',
	'renamewiki_usersubmit' => '変更',
	'renamewiki_user-submit-blocklog' => '利用者のブロック記録を表示',
	'renamewiki_usererrordoesnotexist' => '利用者「<nowiki>$1</nowiki>」は存在しません。',
	'renamewiki_usererrorexists' => '利用者「<nowiki>$1</nowiki>」は既に存在しています。',
	'renamewiki_usererrorinvalid' => '利用者名「<nowiki>$1</nowiki>」は無効な値です。',
	'renamewiki_user-error-request' => '要求を正常に受け付けることができませんでした。
戻ってから再度お試しください。',
	'renamewiki_user-error-same-wiki_user' => '現在と同じ利用者名には変更できません。',
	'renamewiki_usersuccess' => '利用者名を「<nowiki>$1</nowiki>」から「<nowiki>$2</nowiki>」に変更しました。',
	'renamewiki_user-page-exists' => '$1 が既に存在するため、自動での上書きはできませんでした。',
	'renamewiki_user-page-moved' => '$1 を $2 に移動しました。',
	'renamewiki_user-page-unmoved' => '$1 を $2 に移動できませんでした。',
	'renamewiki_userlogpage' => '利用者名変更記録',
	'renamewiki_userlogpagetext' => 'これは、利用者名変更の記録です。',
	'renamewiki_userlogentry' => '$1 を「$2」へ利用者名変更しました',
	'renamewiki_user-log' => '{{PLURAL:$1|$1 回の編集}}。理由: $2',
	'renamewiki_user-move-log' => 'ページを自動的に移動しました（利用者名変更のため：「[[wiki_user:$1|$1]]」から「[[wiki_user:$2|$2]]」）',
	'action-renamewiki_user' => '利用者名の変更',
	'right-renamewiki_user' => '利用者名を変更',
	'renamewiki_user-renamed-notice' => 'この利用者は利用者名を変更しました。
参考のため、利用者名変更記録を以下に示します。',
);

/** Jutish (jysk)
 * @author Huslåke
 * @author Ælsån
 */
$messages['jut'] = array(
	'renamewiki_user' => 'Gæf æ bruger en ny navn',
	'renamewiki_user-desc' => "Gæf en bruger en ny navn (''renamewiki_user'' regt er nøteg)",
	'renamewiki_userold' => 'Nuværende brugernavn:',
	'renamewiki_usernew' => 'Ny brugernavn:',
	'renamewiki_userreason' => "Før hvat dett'er dun:",
	'renamewiki_usermove' => 'Flyt bruger og diskusje sider (og deres substrøk) til ny navn',
	'renamewiki_usersubmit' => 'Gå til',
	'renamewiki_usererrordoesnotexist' => 'Æ bruger "<nowiki>$1</nowiki>" bestä ekke.',
	'renamewiki_usererrorexists' => 'Æ bruger "<nowiki>$1</nowiki>" er ål.',
	'renamewiki_usererrorinvalid' => 'Æ brugernavn "<nowiki>$1</nowiki>" er ogyldegt.',
	'renamewiki_user-error-request' => 'Her har en pråblæm ve enkriige der anfråge. Gå hen og pråbær nurmål.',
	'renamewiki_user-error-same-wiki_user' => 'Du kenst ekke hernåm æ bruger til æselbste nåm als dafør.',
	'renamewiki_usersuccess' => 'Æ bruger "<nowiki>$1</nowiki>" er hernåmt til "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Æ pæge $1 er ål og ken ekke åtåmatisk åverflyttet være.',
	'renamewiki_user-page-moved' => 'Æ pæge $1 er flyttet til $2.',
	'renamewiki_user-page-unmoved' => 'Æ pæge $1 kon ekke flyttet være til $2.',
	'renamewiki_userlogpage' => 'Bruger hernåm log',
	'renamewiki_userlogpagetext' => "Dett'er en log der ændrenger til brugernavner",
	'renamewiki_userlogentry' => 'har hernåmt $1 til "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|en redigærenge|$1 redigærenger}}. Resån: $2',
	'renamewiki_user-move-log' => 'Åtåmatisk flyttet pæge hviil hernåm der bruger "[[wiki_user:$1|$1]]" til "[[wiki_user:$2|$2]]"',
);

/** Javanese (Basa Jawa)
 * @author Meursault2004
 * @author NoiX180
 * @author Pras
 */
$messages['jv'] = array(
	'renamewiki_user' => 'Ngganti jeneng panganggo',
	'renamewiki_user-linkoncontribs' => 'ganti jeneng panganggo',
	'renamewiki_user-linkoncontribs-text' => 'Ganti jenengé panganggo iki',
	'renamewiki_user-desc' => "Ngganti jeneng panganggo (perlu hak aksès ''renamewiki_user'')",
	'renamewiki_userold' => 'Jeneng panganggo saiki:',
	'renamewiki_usernew' => 'Jeneng panganggo anyar:',
	'renamewiki_userreason' => 'Alesan ganti jeneng:',
	'renamewiki_usermove' => 'Mindhah kaca panganggo lan kaca dhiskusiné (sarta subkaca-kacané) menyang jeneng anyar',
	'renamewiki_usersuppress' => 'Aja gawé pangalihan kanggo jeneng anyar',
	'renamewiki_userreserve' => 'Blokir utawa cadhangaké jeneng panganggo lawas supaya ora bisa dianggo manèh',
	'renamewiki_userwarnings' => 'Pènget:',
	'renamewiki_userconfirm' => 'Ya, ganti jeneng panganggo kasebut',
	'renamewiki_usersubmit' => 'Kirim',
	'renamewiki_user-submit-blocklog' => 'Tuduhaké log blokir kanggo panganggo',
	'renamewiki_usererrordoesnotexist' => 'Panganggo "<nowiki>$1</nowiki>" ora ana.',
	'renamewiki_usererrorexists' => 'Panganggo "<nowiki>$1</nowiki>" wis ana.',
	'renamewiki_usererrorinvalid' => 'Jeneng panganggo "<nowiki>$1</nowiki>" ora absah',
	'renamewiki_user-error-request' => 'Ana masalah nalika nampa panyuwunan panjenengan.
Mangga balènana lan nyoba manèh.',
	'renamewiki_user-error-same-wiki_user' => 'Panjenengan ora bisa ngganti jeneng panganggo dadi kaya jeneng asalé.',
	'renamewiki_usersuccess' => 'Panganggo "<nowiki>$1</nowiki>" wis diganti jenengé dadi "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Kaca $1 wis ana lan ora bisa ditimpa sacara otomatis.',
	'renamewiki_user-page-moved' => 'Kaca $1 wis dialihaké menyang $2.',
	'renamewiki_user-page-unmoved' => 'Kaca $1 ora bisa dialihaké menyang $2.',
	'renamewiki_userlogpage' => 'Log ganti jeneng panganggo',
	'renamewiki_userlogpagetext' => 'Iki log owah-owahan jeneng panganggo',
	'renamewiki_userlogentry' => 'Ganti jeneng $1 dadi "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 suntingan|$1 suntingan}}. Alesan: $2',
	'renamewiki_user-move-log' => 'Sacara otomatis mindhah kaca nalika ngganti jeneng panganggo "[[wiki_user:$1|$1]]" dadi "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'ganti jeneng panganggo',
	'right-renamewiki_user' => 'Ganti jeneng panganggo-panganggo',
	'renamewiki_user-renamed-notice' => 'Panganggo iki wis diganti jenengé.
Log panggantèn jeneng sumadhiya ngisor iki kanggo rujukan.',
);

/** Georgian (ქართული)
 * @author BRUTE
 * @author David1010
 * @author Dawid Deutschland
 * @author Malafaya
 * @author Nodar Kherkheulidze
 * @author Sopho
 */
$messages['ka'] = array(
	'renamewiki_user' => 'მომხმარებლის სახელის გამოცვლა',
	'renamewiki_user-linkoncontribs' => 'მომხმარებლის სახელის გადარქმევა',
	'renamewiki_user-linkoncontribs-text' => 'ამ მომხმარებლის სახელის გადარქმევა',
	'renamewiki_user-desc' => 'ამატებს მომხმარებლების სახელის გადარქმევის [[Special:Renamewiki_user|შესაძლებლობას]] (საჭიროა უფლება <code>renamewiki_user</code>)',
	'renamewiki_userold' => 'ამჟამინდელი მომხმარებლის სახელი:',
	'renamewiki_usernew' => 'ახალი მომხმარებლის სახელი:',
	'renamewiki_userreason' => 'სახელის შეცვლის მიზეზი:',
	'renamewiki_usermove' => 'მომხმარებლისა და განხილვის გვერდების (და მათი დაქვემდებარებული გვერდების) გადატანა ახალ დასახელებაზე',
	'renamewiki_usersuppress' => 'არ გადაამისამართოთ ახალ სახელზე',
	'renamewiki_userreserve' => 'ძველი მომხმარებლის სახელის სამომავლო გამოყენების აკრძალვა',
	'renamewiki_userwarnings' => 'გაფრთხილებები:',
	'renamewiki_userconfirm' => 'დიახ, მსურს სახელის გადარქმევა',
	'renamewiki_usersubmit' => 'გაგზავნა',
	'renamewiki_user-submit-blocklog' => 'მომხმარებლის დაბლოკვის ჟურნალის ჩვენება',
	'renamewiki_usererrordoesnotexist' => 'მომხმარებელი „<nowiki>$1</nowiki>“ არ არსებობს',
	'renamewiki_usererrorexists' => 'მომხმარებელი "<nowiki>$1</nowiki>" უკვე არსებობს',
	'renamewiki_usererrorinvalid' => 'მომხმარებლის სახელი „<nowiki>$1</nowiki>“ არასწორია',
	'renamewiki_user-error-request' => 'მოთხოვნის მიღებასთან დაკავშირებით რაღაც პრობლემაა. გთხოვთ, ხელახლა სცადეთ.',
	'renamewiki_user-error-same-wiki_user' => 'თქვენ არ შეგიძლიათ დაარქვათ მომხმარებელს იგივე სახელი, რაც ერქვა წინათ.',
	'renamewiki_usersuccess' => 'მომხმარებლის სახელი — „<nowiki>$1</nowiki>“, შეიცვალა „<nowiki>$2</nowiki>-ით“',
	'renamewiki_user-page-exists' => 'გვერდი $1 უკვე არსებობს და მისი ავტომატურად შენაცვლება შეუძლებელია.',
	'renamewiki_user-page-moved' => 'გვერდი $1 გადატანილია $2-ზე.',
	'renamewiki_user-page-unmoved' => 'არ მოხერხდა გვერდის $1 გადატანა $2-ზე.',
	'renamewiki_userlogpage' => 'მომხმარებლის სახელის გადარქმევის რეგისტრაციის ჟურნალი',
	'renamewiki_userlogpagetext' => 'ეს არის ჟურნალი, სადაც აღრიცხულია მომხმარებლის სახელთა ცვლილებები',
	'renamewiki_userlogentry' => 'სახელი გადაერქვა $1-ს „$2-ზე“',
	'renamewiki_user-log' => '$1 რედაქცია. მიზეზი: $2',
	'renamewiki_user-move-log' => 'ავტომატურად იქნა გადატანილი გვერდი მომხმარებლის „[[wiki_user:$1|$1]]“ სახელის შეცვლისას „[[wiki_user:$2|$2]]-ით“',
	'action-renamewiki_user' => 'მომხმარებლების სახელის გადარქმევა',
	'right-renamewiki_user' => 'მომხმარებლების სახელის გადარქმევა',
	'renamewiki_user-renamed-notice' => 'ამ მომხმარებელს სახელი გადაერქვა.
ქვემოთ მოყვანილია სახელის გადარქმევის ჟურნალი.',
);

/** Kazakh (Arabic script) (قازاقشا (تٴوتە)‏) */
$messages['kk-arab'] = array(
	'renamewiki_user' => 'قاتىسۋشىنى قايتا اتاۋ',
	'renamewiki_userold' => 'اعىمداعى قاتىسۋشى اتى:',
	'renamewiki_usernew' => 'جاڭا قاتىسۋشى اتى:',
	'renamewiki_userreason' => 'قايتا اتاۋ سەبەبى:',
	'renamewiki_usermove' => 'قاتىسۋشىنىڭ جەكە جانە تالقىلاۋ بەتتەرىن (جانە دە ولاردىڭ تومەنگى بەتتەرىن) جاڭا اتاۋعا جىلجىتۋ',
	'renamewiki_usersubmit' => 'جىبەرۋ',
	'renamewiki_usererrordoesnotexist' => '«<nowiki>$1» دەگەن قاتىسۋشى جوق',
	'renamewiki_usererrorexists' => '«$1» دەگەن قاتىسۋشى بار تۇگە',
	'renamewiki_usererrorinvalid' => '«$1» قاتىسۋشى اتى جارامسىز',
	'renamewiki_usersuccess' => '«$1» دەگەن قاتىسۋشى اتى «$2» دەگەنگە اۋىستىرىلدى',
	'renamewiki_user-page-exists' => '$1 دەگەن بەت بار تۇگە, جانە وزدىك تۇردە ونىڭ ۇستىنە ەشتەڭە جازىلمايدى.',
	'renamewiki_user-page-moved' => '$1 دەگەن بەت $2 دەگەن بەتكە جىلجىتىلدى.',
	'renamewiki_user-page-unmoved' => '$1 دەگەن بەت $2 دەگەن بەتكە جىلجىتىلمادى.',
	'renamewiki_userlogpage' => 'قاتىسۋشىنى قايتا اتاۋ جۋرنالى',
	'renamewiki_userlogpagetext' => 'بۇل قاتىسۋشى اتىنداعى وزگەرىستەر جۋرنالى',
	'renamewiki_userlogentry' => '$1 اتاۋىن $2 دەگەنگە وزگەرتتى',
	'renamewiki_user-log' => '$1 تۇزەتۋى بار. $2',
	'renamewiki_user-move-log' => '«[[wiki_user:$1|$1]]» دەگەن قاتىسۋشى اتىن «[[wiki_user:$2|$2]]» دەگەنگە اۋىسقاندا بەت وزدىك تۇردە جىلجىتىلدى',
);

/** Kazakh (Cyrillic script) (қазақша (кирил)‎) */
$messages['kk-cyrl'] = array(
	'renamewiki_user' => 'Қатысушыны қайта атау',
	'renamewiki_userold' => 'Ағымдағы қатысушы аты:',
	'renamewiki_usernew' => 'Жаңа қатысушы аты:',
	'renamewiki_userreason' => 'Қайта атау себебі:',
	'renamewiki_usermove' => 'Қатысушының жеке және талқылау беттерін (және де олардың төменгі беттерін) жаңа атауға жылжыту',
	'renamewiki_usersubmit' => 'Жіберу',
	'renamewiki_usererrordoesnotexist' => '«<nowiki>$1</nowiki>» деген қатысушы жоқ',
	'renamewiki_usererrorexists' => '«<nowiki>$1</nowiki>» деген қатысушы бар түге',
	'renamewiki_usererrorinvalid' => '«<nowiki>$1</nowiki>» қатысушы аты жарамсыз',
	'renamewiki_usersuccess' => '«<nowiki>$1</nowiki>» деген қатысушы аты «<nowiki>$2</nowiki>» дегенге ауыстырылды',
	'renamewiki_user-page-exists' => '$1 деген бет бар түге, және өздік түрде оның үстіне ештеңе жазылмайды.',
	'renamewiki_user-page-moved' => '$1 деген бет $2 деген бетке жылжытылды.',
	'renamewiki_user-page-unmoved' => '$1 деген бет $2 деген бетке жылжытылмады.',
	'renamewiki_userlogpage' => 'Қатысушыны қайта атау журналы',
	'renamewiki_userlogpagetext' => 'Бұл қатысушы атындағы өзгерістер журналы',
	'renamewiki_userlogentry' => '$1 атауын «$2» дегенге өзгертті',
	'renamewiki_user-log' => '$1 түзетуі бар. $2',
	'renamewiki_user-move-log' => '«[[wiki_user:$1|$1]]» деген қатысушы атын «[[wiki_user:$2|$2]]» дегенге ауысқанда бет өздік түрде жылжытылды',
);

/** Kazakh (Latin script) (qazaqşa (latın)‎) */
$messages['kk-latn'] = array(
	'renamewiki_user' => 'Qatıswşını qaýta ataw',
	'renamewiki_userold' => 'Ağımdağı qatıswşı atı:',
	'renamewiki_usernew' => 'Jaña qatıswşı atı:',
	'renamewiki_userreason' => 'Qaýta ataw sebebi:',
	'renamewiki_usermove' => 'Qatıswşınıñ jeke jäne talqılaw betterin (jäne de olardıñ tömengi betterin) jaña atawğa jıljıtw',
	'renamewiki_usersubmit' => 'Jiberw',
	'renamewiki_usererrordoesnotexist' => '«<nowiki>$1</nowiki>» degen qatıswşı joq',
	'renamewiki_usererrorexists' => '«<nowiki>$1</nowiki>» degen qatıswşı bar tüge',
	'renamewiki_usererrorinvalid' => '«<nowiki>$1</nowiki>» qatıswşı atı jaramsız',
	'renamewiki_usersuccess' => '«<nowiki>$1</nowiki>» degen qatıswşı atı «<nowiki>$2</nowiki>» degenge awıstırıldı',
	'renamewiki_user-page-exists' => '$1 degen bet bar tüge, jäne özdik türde onıñ üstine eşteñe jazılmaýdı.',
	'renamewiki_user-page-moved' => '$1 degen bet $2 degen betke jıljıtıldı.',
	'renamewiki_user-page-unmoved' => '$1 degen bet $2 degen betke jıljıtılmadı.',
	'renamewiki_userlogpage' => 'Qatıswşını qaýta ataw jwrnalı',
	'renamewiki_userlogpagetext' => 'Bul qatıswşı atındağı özgerister jwrnalı',
	'renamewiki_userlogentry' => '$1 atawın «$2» degenge özgertti',
	'renamewiki_user-log' => '$1 tüzetwi bar. $2',
	'renamewiki_user-move-log' => '«[[wiki_user:$1|$1]]» degen qatıswşı atın «[[wiki_user:$2|$2]]» degenge awısqanda bet özdik türde jıljıtıldı',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Chhorran
 * @author Lovekhmer
 * @author Thearith
 * @author គីមស៊្រុន
 */
$messages['km'] = array(
	'renamewiki_user' => 'ប្តូរអត្តនាម',
	'renamewiki_user-linkoncontribs' => 'ប្តូរឈ្មោះអ្នកប្រើប្រាស់',
	'renamewiki_user-linkoncontribs-text' => 'ប្ដូរឈ្មោះអ្នកប្រើប្រាស់នេះ',
	'renamewiki_user-desc' => "ប្តូរឈ្មោះអ្នកប្រើប្រាស់(ត្រូវការសិទ្ធិ ''ប្តូរឈ្មោះអ្នកប្រើប្រាស់'')",
	'renamewiki_userold' => 'ឈ្មោះអ្នកប្រើប្រាស់បច្ចុប្បន្ន ៖',
	'renamewiki_usernew' => 'ឈ្មោះអ្នកប្រើប្រាស់ថ្មី៖',
	'renamewiki_userreason' => 'មូលហេតុ៖',
	'renamewiki_usermove' => 'ប្តូរទីតាំងទំព័រអ្នកប្រើប្រាស់និងទំព័រពិភាក្សា(រួមទាំងទំព័ររងផងដែរ)ទៅឈ្មោះថ្មី',
	'renamewiki_usersuppress' => 'កុំបង្កើតការបញ្ជូនបន្តទៅឈ្មោះថ្មី',
	'renamewiki_userreserve' => 'ហាមឃាត់គណនីចាស់ពីការប្រើប្រាស់នាពេលអនាគត',
	'renamewiki_userwarnings' => 'បម្រាម​៖',
	'renamewiki_userconfirm' => 'បាទ/ចាស៎ សូមប្តូរឈ្មោះអ្នកប្រើប្រាស់នេះ',
	'renamewiki_usersubmit' => 'ដាក់ស្នើ',
	'renamewiki_usererrordoesnotexist' => 'អ្នកប្រើប្រាស់ "<nowiki>$1</nowiki>" មិនមាន ។',
	'renamewiki_usererrorexists' => 'អ្នកប្រើប្រាស់ "<nowiki>$1</nowiki>" មានហើយ ។',
	'renamewiki_usererrorinvalid' => 'ឈ្មោះអ្នកប្រើប្រាស់ "<nowiki>$1</nowiki>" មិនត្រឹមត្រូវ ។',
	'renamewiki_user-error-request' => 'មានបញ្ហា​ចំពោះការទទួលសំណើ​។ សូមត្រឡប់ក្រោយ ហើយព្យាយាមម្តងទៀត​។',
	'renamewiki_user-error-same-wiki_user' => 'អ្នកមិនអាចប្តូរឈ្មោះអ្នកប្រើប្រាស់ទៅជាឈ្មោះដូចមុនបានទេ។',
	'renamewiki_usersuccess' => 'អ្នកប្រើប្រាស់ "<nowiki>$1</nowiki>" ត្រូវបានប្តូរឈ្មោះទៅ "<nowiki>$2</nowiki>"។',
	'renamewiki_user-page-exists' => 'ទំព័រ $1 មានហើយ មិនអាចសរសេរជាន់ពីលើដោយស្វ័យប្រវត្តិទេ។',
	'renamewiki_user-page-moved' => 'ទំព័រ$1ត្រូវបានប្តូរទីតាំងទៅ$2ហើយ។',
	'renamewiki_user-page-unmoved' => 'ទំព័រ$1មិនអាចប្តូរទីតាំងទៅ$2បានទេ។',
	'renamewiki_userlogpage' => 'កំនត់ហេតុនៃការប្តូរឈ្មោះអ្នកប្រើប្រាស់',
	'renamewiki_userlogpagetext' => 'នេះជាកំណត់ហេតុនៃបំលាស់ប្តូរនៃឈ្មោះអ្នកប្រើប្រាស់',
	'renamewiki_userlogentry' => 'បានប្តូរឈ្មោះ $1 ទៅជា "$2" ហើយ',
	'renamewiki_user-log' => '{{PLURAL:$1|កំណែប្រែ}}។ ហេតុផល៖ $2',
	'renamewiki_user-move-log' => 'បានប្តូរទីតាំងទំព័រដោយស្វ័យប្រវត្តិក្នុងខណៈពេលប្តូរឈ្មោះអ្នកប្រើប្រាស់ "[[wiki_user:$1|$1]]" ទៅ "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'ប្ដូរឈ្មោះអ្នកប្រើប្រាស់នានា',
	'renamewiki_user-renamed-notice' => 'ឈ្មោះរបស់អ្នកប្រើប្រាស់នេះត្រូវបានប្ដូររួចហើយ។

ខាងក្រោមនេះជាកំណត់ហេតុនៃការប្ដូរឈ្មោះ។',
);

/** Kannada (ಕನ್ನಡ)
 * @author Nayvik
 * @author Shushruth
 */
$messages['kn'] = array(
	'renamewiki_user' => 'ಸದಸ್ಯರನ್ನು ಮರುನಾಮಕರಣ ಮಾಡಿ',
	'renamewiki_userwarnings' => 'ಎಚ್ಚರಿಕೆಗಳು:',
);

/** Korean (한국어)
 * @author Albamhandae
 * @author Ficell
 * @author Klutzy
 * @author Kwj2772
 * @author ToePeu
 * @author 아라
 */
$messages['ko'] = array(
	'renamewiki_user' => '사용자 이름 바꾸기',
	'renamewiki_user-linkoncontribs' => '이름 바꾸기',
	'renamewiki_user-linkoncontribs-text' => '이 사용자의 계정 이름을 바꿉니다.',
	'renamewiki_user-desc' => "사용자 이름을 바꾸기를 위한 [[Special:Renamewiki_user|특수 문서]]를 추가 ('''renamewiki_user''' 권한 필요)",
	'renamewiki_userold' => '기존 사용자 이름:',
	'renamewiki_usernew' => '새 사용자 이름:',
	'renamewiki_userreason' => '바꾸는 이유:',
	'renamewiki_usermove' => '사용자 문서와 토론 문서, 하위 문서를 새 사용자 이름으로 이동하기',
	'renamewiki_usersuppress' => '새 이름으로 넘겨주기를 만들지 않기',
	'renamewiki_userreserve' => '나중에 이전의 이름이 사용되지 않도록 차단하기',
	'renamewiki_userwarnings' => '경고:',
	'renamewiki_userconfirm' => '예, 이름을 바꿉니다.',
	'renamewiki_usersubmit' => '바꾸기',
	'renamewiki_user-submit-blocklog' => '사용자 차단 기록 보이기',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" 사용자가 존재하지 않습니다.',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" 사용자가 이미 존재합니다.',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" 사용자 이름이 잘못되었습니다.',
	'renamewiki_user-error-request' => '요청을 정상적으로 전송하지 못했습니다.
뒤로 가서 다시 시도하세요.',
	'renamewiki_user-error-same-wiki_user' => '이전의 이름과 같은 이름으로는 바꿀 수 없습니다.',
	'renamewiki_usersuccess' => '"<nowiki>$1</nowiki>" 사용자를 "<nowiki>$2</nowiki>" 사용자로 이름을 바꾸었습니다.',
	'renamewiki_user-page-exists' => '$1 문서가 이미 존재하여 자동으로 이동하지 못했습니다.',
	'renamewiki_user-page-moved' => '$1 문서를 $2 문서로 이동했습니다.',
	'renamewiki_user-page-unmoved' => '$1 문서를 $2 문서로 이동하지 못했습니다.',
	'renamewiki_userlogpage' => '이름 바꾸기 기록',
	'renamewiki_userlogpagetext' => '사용자 이름 바꾸기 기록입니다.',
	'renamewiki_userlogentry' => '사용자가 $1 사용자에서 "$2" 사용자로 이름을 바꾸었습니다.',
	'renamewiki_user-log' => '기여 $1회. 이유: $2',
	'renamewiki_user-move-log' => '"[[wiki_user:$1|$1]]" 사용자를 "[[wiki_user:$2|$2]]" 사용자로 바꾸면서 문서를 자동으로 이동함',
	'action-renamewiki_user' => '사용자 이름을 바꿀',
	'right-renamewiki_user' => '사용자 이름 바꾸기',
	'renamewiki_user-renamed-notice' => '이 사용자의 이름을 바꾸었습니다.
아래의 이름 바꾸기 기록을 참고하십시오.',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'renamewiki_user' => 'Metmaacher ömdäufe',
	'renamewiki_user-linkoncontribs' => 'Metmaacher ömnänne',
	'renamewiki_user-linkoncontribs-text' => 'Heh dä Metmaacher ömnänne',
	'renamewiki_user-desc' => '[[Special:Renamewiki_user|Metmaacher ömdäufe]] — ävver do bruch mer et Rääsch „<i lang=en">renamewiki_user</i>“ för.',
	'renamewiki_userold' => 'Dä ahle Metmaacher-Name',
	'renamewiki_usernew' => 'Dä neue Metmaacher-Name',
	'renamewiki_userreason' => 'Jrund för et Ömdäufe:',
	'renamewiki_usermove' => 'De Metmaachersigg met Klaaf- un Ungersigge op dä neue Metmaacher-Name ömstelle',
	'renamewiki_usersuppress' => 'Donn kein Ömleidung op dä neue Name aanlääje',
	'renamewiki_userreserve' => 'Donn dä Name fun dämm Metmaacher dobei sperre, dat_e nit norrens neu aanjemelldt weed.',
	'renamewiki_userwarnings' => 'Warnunge:',
	'renamewiki_userconfirm' => 'Jo, dunn dä Metmaacher ömbenenne un em singe Name ändere',
	'renamewiki_usersubmit' => 'Ömdäufe!',
	'renamewiki_user-submit-blocklog' => 'Logbooch met Spärre för dä Metmaacher',
	'renamewiki_usererrordoesnotexist' => 'Ene Metmaacher „<nowiki>$1</nowiki>“ kenne mer nit.',
	'renamewiki_usererrorexists' => 'Ene Metmaacher met däm Name „<nowiki>$1</nowiki>“ jit et ald.',
	'renamewiki_usererrorinvalid' => 'Ene Metmaacher-Name eß „<nowiki>$1</nowiki>“ ävver nit, dä wöhr nit richtich.',
	'renamewiki_user-error-request' => 'Mer hatte e Problem met Dingem Opdrach.
Bes esu joot un versöök et noch ens.',
	'renamewiki_user-error-same-wiki_user' => 'Do Tuppes! Der ahle un der neue Name es dersellve. Do bengk et Ömdäufe jaanix.',
	'renamewiki_usersuccess' => 'Dä Metmaacher „<nowiki>$1</nowiki>“ es jetz op „<nowiki>$2</nowiki>“ ömjedäuf.',
	'renamewiki_user-page-exists' => 'De Sigg $1 es ald doh, un mer könne se nit automatesch övverschrieve',
	'renamewiki_user-page-moved' => 'De Sigg wood vun „$1“ op „$2“ ömjenannt.',
	'renamewiki_user-page-unmoved' => 'Di Sigg „$1“ kunnt nit op „$2“ ömjenannt wääde.',
	'renamewiki_userlogpage' => 'Logboch vum Metmaacher-Ömdäufe',
	'renamewiki_userlogpagetext' => 'Dat es et Logboch vun de ömjedäufte Metmaachere',
	'renamewiki_userlogentry' => 'hät „$1“ op dä Metmaacher „$2“ ömjedäuf',
	'renamewiki_user-log' => '{{PLURAL:$1|ein Beärbeidung|$1 Beärbeidung|kein Beärbeidung}}. Jrund: $2',
	'renamewiki_user-move-log' => 'Di Sigg weet automatesch ömjenannt weil mer dä Metmaacher „[[wiki_user:$1|$1]]“ op „[[wiki_user:$2|$2]]“ öm am däufe sin.',
	'action-renamewiki_user' => 'Metmaacher ömdäufe',
	'right-renamewiki_user' => 'Metmaacher ömdäufe',
	'renamewiki_user-renamed-notice' => 'Dä Metmaacher es ömjenannt woode.
Dat kanns De unge en däm Ußzoch uss_em Logbooch vum Metmacher Ömnänne fenge.',
);

/** Kurdish (Latin script) (Kurdî (latînî)‎)
 * @author George Animal
 * @author Ghybu
 * @author Gomada
 */
$messages['ku-latn'] = array(
	'renamewiki_user' => 'Navê bikarhêner biguherîne',
	'renamewiki_user-linkoncontribs' => 'navê bikarhêner biguherîne',
	'renamewiki_user-linkoncontribs-text' => 'Navê vî bikarhênerî biguherîne',
	'renamewiki_userold' => 'Navê niha:',
	'renamewiki_usernew' => 'Navê nû:',
	'renamewiki_userreason' => 'Sedema navguherandinê:',
	'renamewiki_usermove' => 'Rûpelên bikarhêner û gotûbêjê xwe (û binrûpelên xwe) bigerîne berve navê nû',
	'renamewiki_userwarnings' => 'Hişyarî:',
	'renamewiki_userconfirm' => 'Erê, navê vî bikarhênerî biguherîne',
	'renamewiki_usersubmit' => 'Nav biguherîne',
	'renamewiki_usererrordoesnotexist' => 'Bikarhêner "<nowiki>$1</nowiki>" tune ye.',
	'renamewiki_usererrorexists' => 'Bikarhêner "<nowiki>$1</nowiki>" berê heye.',
	'renamewiki_usererrorinvalid' => 'Navê "<nowiki>$1</nowiki>" ji bikarhêneran re nayê qebûlkirin.',
	'renamewiki_usersuccess' => 'Navê bikarhênerê "<nowiki>$1</nowiki>" bû "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'Rûpelê $1 berê heye û nikane otomatîk were guherandin.',
	'renamewiki_user-page-moved' => 'Rûpela $1 çû cihê $2.',
	'renamewiki_user-page-unmoved' => 'Rûpela $1 nikanî çûba ciha $2.',
	'renamewiki_userlogpage' => 'Guhertina navê bikarhêner',
	'renamewiki_userlogentry' => 'navê $1 kir "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 beşdarî|$1 beşdarî}}. Sedem: $2',
	'renamewiki_user-move-log' => 'Otomatîk hate guherandin, ji ber ku "[[wiki_user:$1|$1]]" navê xwe guherand û niha bû "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'Navê bikarhêneran biguherîne:',
);

/** Kirghiz (Кыргызча)
 * @author Chorobek
 */
$messages['ky'] = array(
	'renamewiki_user' => 'Колдонуучунун атын өзгөрт',
	'renamewiki_user-linkoncontribs' => 'колдонуучунун атын өзгөрт',
	'renamewiki_user-linkoncontribs-text' => 'Колдонуучунун атын өзгөрт',
	'renamewiki_user-desc' => "Колдонуучуну атын өзгөртүү үчүн (''renamewiki_user'' укугу талап кылынат) [[Special:Renamewiki_user|special page]] кошулат",
	'renamewiki_userold' => 'Азыркы аты:',
	'renamewiki_usernew' => 'Жаңы аты',
	'renamewiki_userreason' => 'Атты өзгөртүүнүн себеби:',
	'renamewiki_usermove' => 'Колдонуучу жана анын талкуу баракчаларын (ички баракчалары менен чогуу) жаңы атка өткөз',
	'renamewiki_usersuppress' => 'Жаңы атка багыттама койбо',
	'renamewiki_userreserve' => 'Колдонуучунун эски атын кийин колдонуу үчүн ээлеп кой',
	'renamewiki_userwarnings' => 'Эскертүүлөр:',
	'renamewiki_userconfirm' => 'Ооба, колдонуучунун атын өзгөрт',
	'renamewiki_usersubmit' => 'Аткар',
);

/** Latin (Latina)
 * @author MF-Warburg
 * @author SPQRobin
 * @author UV
 */
$messages['la'] = array(
	'renamewiki_user' => 'Usorem renominare',
	'renamewiki_userold' => 'Praesente nomen usoris:',
	'renamewiki_usernew' => 'Novum nomen usoris:',
	'renamewiki_userreason' => 'Causa renominationis:',
	'renamewiki_usermove' => 'Movere paginas usoris et disputationis (et subpaginae) in nomen novum',
	'renamewiki_usersubmit' => 'Renominare',
	'renamewiki_usererrordoesnotexist' => 'Usor "<nowiki>$1</nowiki>" non existit',
	'renamewiki_usererrorexists' => 'Usor "<nowiki>$1</nowiki>" iam existit',
	'renamewiki_usererrorinvalid' => 'Nomen usoris "<nowiki>$1</nowiki>" irritum est',
	'renamewiki_usersuccess' => 'Usor "<nowiki>$1</nowiki>" renominatus est in "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'Pagina $1 iam existit et non potest automatice deleri.',
	'renamewiki_user-page-moved' => 'Pagina $1 mota est ad $2.',
	'renamewiki_user-page-unmoved' => 'Pagina $1 ad $2 moveri non potuit.',
	'renamewiki_userlogpage' => 'Index renominationum usorum',
	'renamewiki_userlogpagetext' => 'Hic est index renominationum usorum',
	'renamewiki_userlogentry' => 'renominavit $1 in "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 recensio|$1 recensiones}}. Causa: $2',
	'renamewiki_user-move-log' => 'movit paginam automatice in renominando usorem "[[wiki_user:$1|$1]]" in "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'Usores renominare',
	'renamewiki_user-renamed-notice' => 'Hic usor renominatus est.
Commodule notatio renominationum usoris subter datur.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Les Meloures
 * @author Robby
 */
$messages['lb'] = array(
	'renamewiki_user' => 'Benotzernumm änneren',
	'renamewiki_user-linkoncontribs' => 'Benotzer ëmbenennen',
	'renamewiki_user-linkoncontribs-text' => 'Dëse Benotzer ëmbenennen',
	'renamewiki_user-desc' => "Benotzernumm änneren (Dir braucht dofir  ''renamewiki_user''-Rechter)",
	'renamewiki_userold' => 'Aktuelle Benotzernumm:',
	'renamewiki_usernew' => 'Neie Benotzernumm:',
	'renamewiki_userreason' => "Grond fir d'Ëmbenennung:",
	'renamewiki_usermove' => 'Benotzer- an Diskussiounssäiten (an déi jeweileg Ënnersäiten) op den neie Benotzernumm réckelen',
	'renamewiki_usersuppress' => 'Maacht keng Viruleedungen op den neien Numm',
	'renamewiki_userreserve' => 'Den ale Benotzernumm fir de weitere Gebrauch spären',
	'renamewiki_userwarnings' => 'Warnungen:',
	'renamewiki_userconfirm' => 'Jo, Benotzer ëmbenennen',
	'renamewiki_usersubmit' => 'Ëmbenennen',
	'renamewiki_user-submit-blocklog' => 'Lëscht vun de Späre fir de Benotzer weisen',
	'renamewiki_usererrordoesnotexist' => 'De Benotzer "<nowiki>$1</nowiki>" gëtt et net.',
	'renamewiki_usererrorexists' => 'De Benotzer "<nowiki>$1</nowiki>" gët et schonn.',
	'renamewiki_usererrorinvalid' => 'De Benotzernumm "<nowiki>$1</nowiki>" kann net benotzt ginn.',
	'renamewiki_user-error-request' => 'Et gouf e Problem mat ärer Ufro.
Gitt w.e.g. zréck a versicht et nach eng Kéier.',
	'renamewiki_user-error-same-wiki_user' => 'Dir kënnt kee Benotzernumm änneren, an him deselwechten Numm erëmginn.',
	'renamewiki_usersuccess' => 'De Benotzer "<nowiki>$1</nowiki>" gouf "<nowiki>$2</nowiki>" ëmbenannt.',
	'renamewiki_user-page-exists' => "D'Säit $1 gëtt et schonns a kann net automatesch iwwerschriwwe ginn.",
	'renamewiki_user-page-moved' => "D'Säit $1 gouf op $2 geréckelt.",
	'renamewiki_user-page-unmoved' => "D'Säit $1 konnt net op $2 geréckelt ginn.",
	'renamewiki_userlogpage' => 'Logbuch vun den Ännerunge vum Benotzernumm',
	'renamewiki_userlogpagetext' => 'An dësem Logbuch ginn Ännerunge vu Benotzernimm festgehal.',
	'renamewiki_userlogentry' => 'huet de Benotzer $1 op "$2" ëmbenannt',
	'renamewiki_user-log' => '{{PLURAL:$1|1 Ännerung|$1 Ännerungen}}. Grond: $2',
	'renamewiki_user-move-log' => 'Duerch d\'Réckele vum Benotzer "[[wiki_user:$1|$1]]" op "[[wiki_user:$2|$2]]" goufen déi folgend Säiten automatesch matgeréckelt:',
	'action-renamewiki_user' => 'Benotzer ëmbenennen',
	'right-renamewiki_user' => 'Benotzer ëmbenennen',
	'renamewiki_user-renamed-notice' => "Dëse Benotzer gouf ëmbenannt.
D'Logbuch mat den Ëmbenunngen ass hei ënnendrënner.",
);

/** Limburgish (Limburgs)
 * @author Matthias
 * @author Ooswesthoesbes
 * @author Pahles
 * @author Tibor
 */
$messages['li'] = array(
	'renamewiki_user' => 'Herneum gebroeker',
	'renamewiki_user-linkoncontribs' => 'herneum gebroeker',
	'renamewiki_user-linkoncontribs-text' => 'Hernöm deze broeker',
	'renamewiki_user-desc' => "Voog 'n [[Special:Renamewiki_user|speciaal pazjwna]] toe óm 'ne gebroeker te hernömme (doe höbs hiej ''renamewiki_user''-rech veur neudig)",
	'renamewiki_userold' => 'Hujige gebroekersnaam:',
	'renamewiki_usernew' => 'Nuje gebroekersnaam:',
	'renamewiki_userreason' => 'Ree veur hernömme:',
	'renamewiki_usermove' => "De gebroekerspazjena en euverlèkpazjena (en eventueel subpazjena's) hernömmme nao de nuje gebroekersnaam",
	'renamewiki_usersuppress' => 'Maak gein redireks nao de nuje naam',
	'renamewiki_userreserve' => 'Veurkómme det de aaje gebroeker opnuuj wörd geregistreerd',
	'renamewiki_userwarnings' => 'Waarschuwinge:',
	'renamewiki_userconfirm' => 'Jao, hernaam gebroeker',
	'renamewiki_usersubmit' => 'Herneum',
	'renamewiki_user-submit-blocklog' => 'Tuin bloklogbook veure gebroeker',
	'renamewiki_usererrordoesnotexist' => 'De gebroeker "<nowiki>$1</nowiki>" besteit neet.',
	'renamewiki_usererrorexists' => 'De gebroeker "<nowiki>$1</nowiki>" besteit al.',
	'renamewiki_usererrorinvalid' => 'De gebroekersnaam "<nowiki>$1</nowiki>" is óngeljig.',
	'renamewiki_user-error-request' => "d'r Woor 'n perbleem bie 't óntvange vanne aanvraog. Lèvver trök te gaon en opnuuj te perbere/",
	'renamewiki_user-error-same-wiki_user' => 'De kèns gein gebroekers herneume nao dezelfde naam.',
	'renamewiki_usersuccess' => 'De gebroeker "<nowiki>$1</nowiki>" is hernömp nao "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'De pazjena $1 besteit al en kan neet automatisch euversjreve waere,',
	'renamewiki_user-page-moved' => 'De pagina $1 is hernömp nao $2.',
	'renamewiki_user-page-unmoved' => 'De pagina $1 kon neet hernömp waere nao $2.',
	'renamewiki_userlogpage' => 'Logbook gebroekersnaamwieziginge',
	'renamewiki_userlogpagetext' => 'Hiejónger staon gebroekersname die verangerdj zeen',
	'renamewiki_userlogentry' => 'haet $1 hernömp nao "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 bewerking|$1 bewerkinge}}. Ree: $2',
	'renamewiki_user-move-log' => 'Automatisch hernömp bie \'t wiezige van gebroeker "[[wiki_user:$1|$1]]" nao "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'gebroekers van naam te verangere',
	'right-renamewiki_user' => 'Gebroekers hernaome',
	'renamewiki_user-renamed-notice' => "Deze gebroeker is herneump.
Relevante regels oet 't logbook staon hieónger.",
);

/** Lithuanian (lietuvių)
 * @author Eitvys200
 * @author Homo
 * @author Hugo.arg
 * @author Matasg
 */
$messages['lt'] = array(
	'renamewiki_user' => 'Pervadinti naudotoją',
	'renamewiki_user-linkoncontribs' => 'Pervadinti naudotoją',
	'renamewiki_user-linkoncontribs-text' => 'Pervardyti šį vartotoją',
	'renamewiki_user-desc' => "Pervadinti naudotoją (reikia ''pervadintojo'' teisių)",
	'renamewiki_userold' => 'Esamas naudotojo vardas:',
	'renamewiki_usernew' => 'Naujas naudotojo vardas:',
	'renamewiki_userreason' => 'Pervadinimo priežastis:',
	'renamewiki_usermove' => 'Perkelti naudotojo ir aptarimo puslapius (bei jo subpuslapius) prie naujo vardo',
	'renamewiki_userreserve' => 'Užblokuoti senąjį naudotojo vardą nuo galimybių naudoti ateityje',
	'renamewiki_userwarnings' => 'Įspėjimai:',
	'renamewiki_userconfirm' => 'Taip, pervadinti naudotoją',
	'renamewiki_usersubmit' => 'Patvirtinti',
	'renamewiki_usererrordoesnotexist' => 'Naudotojas "<nowiki>$1</nowiki>" neegzistuoja.',
	'renamewiki_usererrorexists' => 'Naudotojas "<nowiki>$1</nowiki>" jau egzistuoja.',
	'renamewiki_usererrorinvalid' => 'Naudotojo vardas "<nowiki>$1</nowiki>" netinkamas.',
	'renamewiki_user-error-request' => 'Iškilo prašymo gavimo problema.
Prašome eiti atgal ir bandyti iš naujo.',
	'renamewiki_user-error-same-wiki_user' => 'Jūs negalite pervadinti naudotojo į tokį pat vardą, kaip pirmiau.',
	'renamewiki_usersuccess' => 'Naudotojas "<nowiki>$1</nowiki>" buvo pervadintas į "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Puslapis $1 jau egzistuoja ir negali būti automatiškai perrašytas.',
	'renamewiki_user-page-moved' => 'Puslapis $1 buvo perkeltas į $2.',
	'renamewiki_user-page-unmoved' => 'Puslapis $1 negali būti perkeltas į $2.',
	'renamewiki_userlogpage' => 'Naudotojų pervadinimo sąrašas',
	'renamewiki_userlogpagetext' => 'Tai yra naudotojų vardų pakeitimų sąrašas',
	'renamewiki_userlogentry' => 'pervadintas $1 į „$2“',
	'renamewiki_user-log' => '{{PLURAL:$1|1 redagavimas|$1 redagavimų(ai)}}. Priežastis: $2',
	'renamewiki_user-move-log' => 'Puslapis automatiškai perkeltas, kai buvo pervadinamas naudotojas "[[wiki_user:$1|$1]]" į "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'pervadinti naudotojus',
	'right-renamewiki_user' => 'Pervadinti naudotojus',
);

/** Latvian (latviešu)
 * @author Papuass
 * @author Xil
 */
$messages['lv'] = array(
	'renamewiki_user' => 'Pārsaukt lietotāju',
	'renamewiki_user-linkoncontribs' => 'pārsaukt lietotāju',
	'renamewiki_user-linkoncontribs-text' => 'Pārsaukt šo lietotāju',
	'renamewiki_userold' => 'Pašreizējais lietotāja vārds:',
	'renamewiki_usernew' => 'Jaunais lietotāja vārds:',
	'renamewiki_userreason' => 'Pārsaukšanas iemesls:',
	'renamewiki_userreserve' => 'Bloķēt veco lietotājvārdu no turpmākas izmantošanas',
	'renamewiki_userwarnings' => 'Brīdinājumi:',
	'renamewiki_userconfirm' => 'Jā, pārdēvēt lietotāju',
	'renamewiki_usersubmit' => 'Iesniegt',
	'renamewiki_usererrorexists' => 'Lietotājs "<nowiki>$1</nowiki>" jau ir.',
	'renamewiki_usersuccess' => 'Lietotājs "<nowiki>$1</nowiki>" pārdēvēts par "<nowiki>$2</nowiki>".',
	'renamewiki_userlogpage' => 'Lietotāju pārdēvēšanas reģistrs',
	'renamewiki_userlogpagetext' => 'Lietotājvārdu maiņas reģistrs',
	'renamewiki_userlogentry' => 'pārsauca $1 par "$2"',
	'action-renamewiki_user' => 'pārsaukt lietotājus',
	'right-renamewiki_user' => 'Pārsaukt lietotājus',
);

/** Malagasy (Malagasy)
 * @author Jagwar
 */
$messages['mg'] = array(
	'renamewiki_user' => "Hanova ny anaran'ny mpikambana",
	'renamewiki_user-linkoncontribs' => "Manova ny anaran'ny mpikambana",
	'renamewiki_user-linkoncontribs-text' => "Hanova ny anaran'ity mpikambana ity",
	'renamewiki_userold' => 'Anaram-pikambana ankehitriny :',
	'renamewiki_usernew' => 'Anaram-pikambana vaovao :',
	'renamewiki_userreason' => "Anton'ny fanovana anarana :",
	'renamewiki_usermove' => "Afindrany pejim-pikambana any amin'ny anarana vaovao",
	'renamewiki_userwarnings' => 'Fampitandremana :',
	'renamewiki_userconfirm' => 'Eny, soloy anarana ilay mpikambana',
	'renamewiki_usersubmit' => 'Alefa',
	'renamewiki_userlogpage' => 'Laogim-panovana anaram-pikambana',
	'right-renamewiki_user' => "Manova ny anaran'ny mpikambana",
);

/** Macedonian (македонски)
 * @author Bjankuloski06
 * @author Brest
 * @author Misos
 */
$messages['mk'] = array(
	'renamewiki_user' => 'Преименувај корисник',
	'renamewiki_user-linkoncontribs' => 'преименувај корисник',
	'renamewiki_user-linkoncontribs-text' => 'Преименувај го корисников',
	'renamewiki_user-desc' => "Додава [[Special:Renamewiki_user|специјална страница]] за преименување на корисник (бара право на ''renamewiki_user'')",
	'renamewiki_userold' => 'Сегашно корисничко име:',
	'renamewiki_usernew' => 'Ново корисничко име:',
	'renamewiki_userreason' => 'Причина за преименувањето:',
	'renamewiki_usermove' => 'Премести корисничка страница и страници за разговор (и нивните потстраници) под новото име',
	'renamewiki_usersuppress' => 'Не создавај пренасочувања кон новото име',
	'renamewiki_userreserve' => 'Блокирање на старото корисничко име, да не може да се користи во иднина',
	'renamewiki_userwarnings' => 'Предупредувања:',
	'renamewiki_userconfirm' => 'Да, преименувај го корисникот',
	'renamewiki_usersubmit' => 'Внеси',
	'renamewiki_user-submit-blocklog' => 'Дневник на блокирања за корисникот',
	'renamewiki_usererrordoesnotexist' => 'Корисникот „<nowiki>$1</nowiki>“ не постои',
	'renamewiki_usererrorexists' => 'Корисникот „<nowiki>$1</nowiki>“ веќе постои',
	'renamewiki_usererrorinvalid' => 'Корисничкото име „<nowiki>$1</nowiki>“ не е важечко.',
	'renamewiki_user-error-request' => 'Се јави проблем при примањето на барањето.
Вратете се и обидете се повторно.',
	'renamewiki_user-error-same-wiki_user' => 'Не можете да го преименувате корисникот во име кое е исто како претходното.',
	'renamewiki_usersuccess' => 'Корисникот „<nowiki>$1</nowiki>“ е преименуван во „<nowiki>$2</nowiki>“',
	'renamewiki_user-page-exists' => 'Страницата $1 веќе постои и не може автоматски да се замени со друга содржина.',
	'renamewiki_user-page-moved' => 'Страницата $1 е преместена на $2.',
	'renamewiki_user-page-unmoved' => 'Страницата $1 неможеше да се премести на $2.',
	'renamewiki_userlogpage' => 'Дневник на преименувања на корисници',
	'renamewiki_userlogpagetext' => 'Ово е дневник на преименувања на корисници',
	'renamewiki_userlogentry' => 'го преименуваше $1 во „$2“',
	'renamewiki_user-log' => '{{PLURAL:$1|1 уредување|$1 уредувања}}. Образложение: $2',
	'renamewiki_user-move-log' => 'Автоматски преместена страница при преименување на корисникот „[[wiki_user:$1|$1]]“ во „[[wiki_user:$2|$2]]“',
	'action-renamewiki_user' => 'преименување на корисници',
	'right-renamewiki_user' => 'Преименување корисници',
	'renamewiki_user-renamed-notice' => 'Овој корисник е преименуван.
Подолу е приложен дневникот на преименување за споредба.',
);

/** Malayalam (മലയാളം)
 * @author Praveenp
 * @author Shijualex
 */
$messages['ml'] = array(
	'renamewiki_user' => 'ഉപയോക്താവിനെ പുനർനാമകരണം ചെയ്യുക',
	'renamewiki_user-linkoncontribs' => 'ഉപയോക്തൃ പുനർനാമകരണം',
	'renamewiki_user-linkoncontribs-text' => 'ഈ ഉപയോക്താവിന്റെ പേരു മാറ്റുക',
	'renamewiki_user-desc' => "ഉപയോക്താവിനെ പുനർനാമകരണം ചെയ്യുവാനുള്ള (''പുനർനാമകരണ'' അവകാശം വേണം) ഒരു [[Special:Renamewiki_user|പ്രത്യേക താൾ]] ചേർക്കുന്നു",
	'renamewiki_userold' => 'ഇപ്പോഴത്തെ ഉപയോക്തൃനാമം:',
	'renamewiki_usernew' => 'പുതിയ ഉപയോക്തൃനാമം:',
	'renamewiki_userreason' => 'ഉപയോക്തൃനാമം മാറ്റാനുള്ള കാരണം:',
	'renamewiki_usermove' => 'നിലവിലുള്ള ഉപയോക്തൃതാളും, ഉപയോക്താവിന്റെ സം‌വാദം താളും (ഉപതാളുകൾ അടക്കം) പുതിയ നാമത്തിലേക്കു മാറ്റുക.',
	'renamewiki_usersuppress' => 'പുതിയ നാമത്തിലേയ്ക്ക് തിരിച്ചുവിടലുകളൊന്നും സൃഷ്ടിക്കരുത്',
	'renamewiki_userreserve' => 'പഴയ ഉപയോക്തൃനാമം ഭാവിയിൽ ഉപയോഗിക്കുന്നതു തടയുക',
	'renamewiki_userwarnings' => 'മുന്നറിയിപ്പുകൾ:',
	'renamewiki_userconfirm' => 'അതെ, ഉപയോക്താവിനെ പുനർനാമകരണം ചെയ്യുക',
	'renamewiki_usersubmit' => 'സമർപ്പിക്കുക',
	'renamewiki_user-submit-blocklog' => 'ഉപയോക്താവിനെക്കുറിച്ചുള്ള തടയൽ രേഖ പ്രദർശിപ്പിക്കുക',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>"  എന്ന ഉപയോക്താവ് നിലവിലില്ല.',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്താവ് നിലവിലുണ്ട്.',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്തൃനാമം അസാധുവാണ്‌.',
	'renamewiki_user-error-request' => 'അപേക്ഷ സ്വീകരിക്കുമ്പോൾ പിഴവ് സം‌ഭവിച്ചു. ദയവായി തിരിച്ചു പോയി വീണ്ടും പരിശ്രമിക്കുക.',
	'renamewiki_user-error-same-wiki_user' => 'നിലവിലുള്ള ഒരു ഉപയോക്തൃനാമത്തിലേക്കു വേറൊരു ഉപയോക്തൃനാമം പുനർനാമകരണം നടത്തുവാൻ സാധിക്കില്ല.',
	'renamewiki_usersuccess' => '"<nowiki>$1</nowiki>" എന്ന ഉപയോക്താവിനെ "<nowiki>$2</nowiki>" എന്ന നാമത്തിലേക്കു പുനർനാമകരണം ചെയ്തിരിക്കുന്നു.',
	'renamewiki_user-page-exists' => '$1 എന്ന താൾ നിലവിലുള്ളതിനാൽ അതിനെ യാന്ത്രികമായി മാറ്റാൻ കഴിയില്ല.',
	'renamewiki_user-page-moved' => '$1 എന്ന താൾ $2 എന്നാക്കിയിരിക്കുന്നു.',
	'renamewiki_user-page-unmoved' => '$1 എന്ന താൾ $2 എന്നാക്കാൻ സാദ്ധ്യമല്ല.',
	'renamewiki_userlogpage' => 'ഉപയോക്തൃ പുനർനാമകരണ രേഖ',
	'renamewiki_userlogpagetext' => 'ഈ പ്രവർത്തനരേഖ ഉപയോക്തൃനാമം പുനർനാമകരണം നടത്തിയതിന്റേതാണ്‌.',
	'renamewiki_userlogentry' => '$1 എന്ന ഉപയോക്താവിനെ "$2" എന്നു പുനർനാമകരണം ചെയ്തിരിക്കുന്നു.',
	'renamewiki_user-log' => '{{PLURAL:$1|ഒരു തിരുത്തൽ|$1 തിരുത്തലുകൾ}}. കാരണം: $2',
	'renamewiki_user-move-log' => '"[[wiki_user:$1|$1]]" എന്ന ഉപയോക്താവിനെ "[[wiki_user:$2|$2]]" എന്നു പുനർനാമകരണം ചെയ്തപ്പോൾ താൾ യാന്ത്രികമായി മാറ്റി.',
	'action-renamewiki_user' => 'ഉപയോക്താക്കളുടെ പുനർനാമകരണം',
	'right-renamewiki_user' => 'ഉപയോക്തൃ പുനർനാമകരണം',
	'renamewiki_user-renamed-notice' => 'ഈ ഉപയോക്താവിനെ പുനർനാമകരണം ചെയ്തിരിക്കുന്നു.
പുനർനാമകരണ രേഖ അവലംബമായി പരിശോധിക്കാനായി താഴെ കൊടുത്തിരിക്കുന്നു.',
);

/** Mongolian (монгол)
 * @author Chinneeb
 */
$messages['mn'] = array(
	'renamewiki_usersubmit' => 'Явуулах',
);

/** Marathi (मराठी)
 * @author Kaajawa
 * @author Kaustubh
 * @author Rahuldeshmukh101
 * @author V.narsikar
 */
$messages['mr'] = array(
	'renamewiki_user' => 'सदस्यनाम बदला',
	'renamewiki_user-linkoncontribs' => 'सदस्यनाम बदला',
	'renamewiki_user-linkoncontribs-text' => 'ह्या सदस्याचे नाव बदला',
	'renamewiki_user-desc' => "सदस्यनाम बदला (यासाठी तुम्हाला ''सदस्यनाम बदलण्याचे अधिकार'' असणे आवश्यक आहे)",
	'renamewiki_userold' => 'सध्याचे सदस्यनाम:',
	'renamewiki_usernew' => 'नवीन सदस्यनाम:',
	'renamewiki_userreason' => 'नाम बदलण्याचे कारण:',
	'renamewiki_usermove' => 'सदस्य तसेच सदस्य चर्चापान (तसेच त्यांची उपपाने) नवीन सदस्यनामाकडे स्थानांतरीत करा',
	'renamewiki_usersuppress' => 'नवीन नावाकडे पुर्ननिर्देशने तयार करू नका',
	'renamewiki_userreserve' => 'जुने सदस्य खाते पुढील वापरासाठी अवरुद्ध करा',
	'renamewiki_userwarnings' => 'ताकीद:',
	'renamewiki_userconfirm' => 'होय, सदस्याचे नाव बदला',
	'renamewiki_usersubmit' => 'पाठवा',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" नावाचा सदस्य अस्तित्वात नाही.',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" नावाचा सदस्य अगोदरच अस्तित्वात आहे',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" हे नाव चुकीचे आहे.',
	'renamewiki_user-error-request' => 'हे काम करताना त्रुटी आढळलेली आहे. कृपया मागे जाऊन परत प्रयत्न करा.',
	'renamewiki_user-error-same-wiki_user' => 'तुम्ही एखाद्या सदस्याला परत पूर्वीच्या नावाकडे बदलू शकत नाही',
	'renamewiki_usersuccess' => '"<nowiki>$1</nowiki>" या सदस्याचे नाव "<nowiki>$2</nowiki>" ला बदललेले आहे.',
	'renamewiki_user-page-exists' => '$1 हे पान अगोदरच अस्तित्वात आहे व आपोआप पुनर्लेखन करता येत नाही.',
	'renamewiki_user-page-moved' => '$1 हे पान $2 मथळ्याखाली स्थानांतरीत केले.',
	'renamewiki_user-page-unmoved' => '$1 हे पान $2 मथळ्याखाली स्थानांतरीत करू शकत नाही.',
	'renamewiki_userlogpage' => 'सदस्यनाम बदल यादी',
	'renamewiki_userlogpagetext' => 'ही सदस्यनामांमध्ये केलेल्या बदलांची यादी आहे.',
	'renamewiki_userlogentry' => '$1 ला "$2" केले',
	'renamewiki_user-log' => '{{PLURAL:$1|१ संपादन|$1 संपादने}}. कारण: $2',
	'renamewiki_user-move-log' => '"[[wiki_user:$1|$1]]" ला "[[wiki_user:$2|$2]]" बदलताना आपोआप सदस्य पान स्थानांतरीत केलेले आहे.',
	'right-renamewiki_user' => 'सदस्यांची नावे बदला',
	'renamewiki_user-renamed-notice' => 'या सदस्यास पुनर्नामित करण्यात आले आहे.
पुनर्नामाचा क्रमलेख संदर्भासाठी खाली दिलेला आहे.',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 * @author Aurora
 * @author Aviator
 */
$messages['ms'] = array(
	'renamewiki_user' => 'Tukar nama pengguna',
	'renamewiki_user-linkoncontribs' => 'tukar nama pengguna',
	'renamewiki_user-linkoncontribs-text' => 'Tukar nama pengguna ini',
	'renamewiki_user-desc' => "Menukar nama pengguna (memerlukan hak ''renamewiki_user'')",
	'renamewiki_userold' => 'Nama semasa:',
	'renamewiki_usernew' => 'Nama baru:',
	'renamewiki_userreason' => 'Sebab tukar:',
	'renamewiki_usermove' => 'Pindahkan laman pengguna dan laman perbincangannya (berserta semua sublaman yang ada) ke nama baru',
	'renamewiki_usersuppress' => 'Jangan buat lencongan ke nama baru',
	'renamewiki_userreserve' => 'Pelihara nama pengguna lama supaya tidak digunakan lagi',
	'renamewiki_userwarnings' => 'Amaran:',
	'renamewiki_userconfirm' => 'Ya, tukar nama pengguna ini',
	'renamewiki_usersubmit' => 'Hantar',
	'renamewiki_user-submit-blocklog' => 'Tunjukkan log sekatan pengguna',
	'renamewiki_usererrordoesnotexist' => 'Pengguna "<nowiki>$1</nowiki>" tidak wujud.',
	'renamewiki_usererrorexists' => 'Pengguna "<nowiki>$1</nowiki>" telah pun wujud.',
	'renamewiki_usererrorinvalid' => 'Nama pengguna "<nowiki>$1</nowiki>" tidak sah.',
	'renamewiki_user-error-request' => 'Berlaku masalah ketika menerima permintaan anda.
Sila undur dan cuba lagi.',
	'renamewiki_user-error-same-wiki_user' => 'Anda tidak boleh menukar nama pengguna kepada nama yang sama.',
	'renamewiki_usersuccess' => 'Nama "<nowiki>$1</nowiki>" telah ditukar menjadi "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Laman $1 telah pun wujud dan tidak boleh ditulis ganti secara automatik.',
	'renamewiki_user-page-moved' => 'Laman $1 telah dipindahkan ke $2.',
	'renamewiki_user-page-unmoved' => 'Laman $1 tidak dapat dipindahkan ke $2.',
	'renamewiki_userlogpage' => 'Log penukaran nama pengguna',
	'renamewiki_userlogpagetext' => 'Ini ialah log penukaran nama pengguna.',
	'renamewiki_userlogentry' => 'telah menukar nama $1 menjadi "$2"',
	'renamewiki_user-log' => '$1 suntingan. Sebab: $2',
	'renamewiki_user-move-log' => 'Memindahkan laman secara automatik ketika menukar nama "[[wiki_user:$1|$1]]" menjadi "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'menukar nama pengguna',
	'right-renamewiki_user' => 'Menukar nama pengguna',
	'renamewiki_user-renamed-notice' => 'Pengguna ini telah dinamakan semula.
Log penukaran nama ditunjukkan di bawah sebagai rujukan.',
);

/** Maltese (Malti)
 * @author Chrisportelli
 * @author Roderick Mallia
 */
$messages['mt'] = array(
	'renamewiki_user' => 'Semmi utent mill-ġdid',
	'renamewiki_user-linkoncontribs' => 'semmi l-utent mill-ġdid',
	'renamewiki_user-linkoncontribs-text' => "Erġa' semmi lil dan l-utent",
	'renamewiki_user-desc' => "Iżżid [[Special:Renamewiki_user|paġna speċjali]] sabiex issemmi utent mill-ġdid (huwa neċessarju li tħaddan id-dritt ''renamewiki_user'')",
	'renamewiki_userold' => 'Isem tal-utent attwali:',
	'renamewiki_usernew' => 'Isem tal-utent il-ġdid:',
	'renamewiki_userreason' => 'Raġuni għall-bidla fl-isem:',
	'renamewiki_usermove' => "Mexxi l-paġna tal-utent, il-paġna ta' diskussjoni u s-sottopaġni taħt l-isem il-ġdid",
	'renamewiki_usersuppress' => 'Toħloqx rindirizzi lejn l-isem il-ġdid',
	'renamewiki_userreserve' => 'Imblokka l-użu tal-isem il-qadim fil-futur',
	'renamewiki_userwarnings' => 'Twissijiet:',
	'renamewiki_userconfirm' => 'Iva, semmi mill-ġdid dan l-utent',
	'renamewiki_usersubmit' => 'Ibgħat',
	'renamewiki_user-submit-blocklog' => 'Uri r-reġistru tal-imblukkar għall-utent',
	'renamewiki_usererrordoesnotexist' => 'L-utent "<nowiki>$1</nowiki>" ma jeżistix.',
	'renamewiki_usererrorexists' => 'L-utent "<nowiki>$1</nowiki>" diġà jeżisti.',
	'renamewiki_usererrorinvalid' => 'L-isem tal-utent "<nowiki>$1</nowiki>" hu invalidu.',
	'renamewiki_user-error-request' => "Kien hemm problema fl-ilqugħ tar-rikjesta tiegħek. Jekk jogħġbok mur lura u erġa' pprova.",
	'renamewiki_user-error-same-wiki_user' => 'Ma tistax issemmi utent l-istess isem li kellu qabel.',
	'renamewiki_usersuccess' => 'L-utent "<nowiki>$1</nowiki>" issemma mill-ġdid għal "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Il-paġna $1 diġà teżisti u ma tistax tiġi miktuba fuqha awtomatikament.',
	'renamewiki_user-page-moved' => 'Il-paġna $1 tmexxiet lejn $2.',
	'renamewiki_user-page-unmoved' => 'Il-paġna $1 ma setgħetx titmexxa lejn $2.',
	'renamewiki_userlogpage' => 'Reġistru tal-utenti msemmijin mill-ġdid',
	'renamewiki_userlogpagetext' => "Dan huwa r-reġistru ta' tibdil tal-ismijiet tal-utenti.",
	'renamewiki_userlogentry' => 'biddel l-isem ta\' $1 għal "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|modifika waħda|$1 modifiki}}. Raġuni: $2',
	'renamewiki_user-move-log' => 'Paġna mmexxiha matul il-bidla tal-utent "[[wiki_user:$1|$1]]" għal "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'tbiddel l-ismijiet tal-utenti',
	'right-renamewiki_user' => 'Ibiddel l-isem tal-utenti',
	'renamewiki_user-renamed-notice' => "Dan l-utent reġa' ssemma mill-ġdid. Ir-reġistru tal-ismijiet ġodda huwa mogħti bħala referenza.",
);

/** Erzya (эрзянь)
 * @author Botuzhaleny-sodamo
 */
$messages['myv'] = array(
	'renamewiki_usernew' => 'Од лемесь:',
	'renamewiki_userreserve' => 'Озавтомс ташто совицянь лементь саймес, тевс илязо нолдаво седе тов',
	'renamewiki_userconfirm' => 'Истя, макст совицянтень од лем',
	'renamewiki_usersubmit' => 'Максомс',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" совицясь арась.',
);

/** Nahuatl (Nāhuatl)
 * @author Fluence
 */
$messages['nah'] = array(
	'renamewiki_usersubmit' => 'Tiquihuāz',
);

/** Min Nan Chinese (Bân-lâm-gú) */
$messages['nan'] = array(
	'renamewiki_user' => 'Kái iōng-chiá ê miâ',
	'renamewiki_user-page-moved' => '$1 í-keng sóa khì tī $2.',
	'renamewiki_userlogpagetext' => 'Chit-ê log lia̍t-chhut kái-piàn iōng-chiá miâ-jī ê tōng-chok.',
);

/** Norwegian Bokmål (norsk (bokmål)‎)
 * @author Danmichaelo
 * @author Event
 * @author Nghtwlkr
 */
$messages['nb'] = array(
	'renamewiki_user' => 'Døp om bruker',
	'renamewiki_user-linkoncontribs' => 'døp om bruker',
	'renamewiki_user-linkoncontribs-text' => 'Døp om denne brukeren',
	'renamewiki_user-desc' => "Legger til en [[Special:Renamewiki_user|spesialside]] for å døpe om en bruker (krever ''renamewiki_user''-rettigheter)",
	'renamewiki_userold' => 'Nåværende brukernavn:',
	'renamewiki_usernew' => 'Nytt brukernavn:',
	'renamewiki_userreason' => 'Årsak for omdøping:',
	'renamewiki_usermove' => 'Flytt bruker- og brukerdiskusjonssider (og deres undersider) til nytt navn',
	'renamewiki_usersuppress' => 'Ikke opprett omdirigeringer til det nye navnet',
	'renamewiki_userreserve' => 'Blokker det gamle brukernavnet fra framtidig bruk',
	'renamewiki_userwarnings' => 'Advarsler:',
	'renamewiki_userconfirm' => 'Ja, døp om brukeren',
	'renamewiki_usersubmit' => 'Utfør',
	'renamewiki_user-submit-blocklog' => 'Vis blokkeringslogg for bruker',
	'renamewiki_usererrordoesnotexist' => 'Brukeren «<nowiki>$1</nowiki>» finnes ikke.',
	'renamewiki_usererrorexists' => 'Brukeren «<nowiki>$1</nowiki>» finnes allerede.',
	'renamewiki_usererrorinvalid' => 'Brukernavnet «<nowiki>$1</nowiki>» er ugyldig.',
	'renamewiki_user-error-request' => 'Det var et problem med å motta forespørselen.
Gå tilbake og prøv igjen.',
	'renamewiki_user-error-same-wiki_user' => 'Du kan ikke gi en bruker samme navn som han/hun allerede har.',
	'renamewiki_usersuccess' => 'Brukeren «<nowiki>$1</nowiki>» har blitt omdøpt til «<nowiki>$2</nowiki>».',
	'renamewiki_user-page-exists' => 'Siden $1 finnes allerede, og kunne ikke erstattes automatisk.',
	'renamewiki_user-page-moved' => 'Siden $1 har blitt flyttet til $2.',
	'renamewiki_user-page-unmoved' => 'Siden $1 kunne ikke flyttes til $2.',
	'renamewiki_userlogpage' => 'Omdøpingslogg',
	'renamewiki_userlogpagetext' => 'Dette er en logg over endringer i brukernavn.',
	'renamewiki_userlogentry' => 'døpte om $1 til «$2»',
	'renamewiki_user-log' => '{{PLURAL:$1|1 bidrag|$1 bidrag}}. Årsak: $2',
	'renamewiki_user-move-log' => 'Flyttet side automatisk under omdøping av brukeren «[[wiki_user:$1|$1]]» til «[[wiki_user:$2|$2]]»',
	'action-renamewiki_user' => 'endre navn på brukere',
	'right-renamewiki_user' => 'Endre navn på brukere',
	'renamewiki_user-renamed-notice' => 'Denne brukeren har fått endret navn.
Til informasjon er navnendringsloggen vist nedenfor.',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'renamewiki_user' => 'Brukernaam ännern',
	'renamewiki_user-desc' => "Föögt en [[Special:Renamewiki_user|Spezialsied]] to för dat Ne’en-Naam-Geven för Brukers (''renamewiki_user''-Recht nödig)",
	'renamewiki_userold' => 'Brukernaam nu:',
	'renamewiki_usernew' => 'Nee Brukernaam:',
	'renamewiki_userreason' => 'Gründ för den ne’en Naam:',
	'renamewiki_usermove' => 'Brukersieden op’n ne’en Naam schuven',
	'renamewiki_userreserve' => 'Den olen Brukernaam dor vör schulen, dat he noch wedder nee anmellt warrt',
	'renamewiki_userwarnings' => 'Wohrschauels:',
	'renamewiki_userconfirm' => 'Jo, den Bruker en ne’en Naam geven',
	'renamewiki_usersubmit' => 'Ännern',
	'renamewiki_usererrordoesnotexist' => "Bruker ''<nowiki>$1</nowiki>'' gifft dat nich",
	'renamewiki_usererrorexists' => "Bruker ''<nowiki>$1</nowiki>'' gifft dat al",
	'renamewiki_usererrorinvalid' => "Brukernaam ''<nowiki>$1</nowiki>'' geiht nich",
	'renamewiki_user-error-request' => 'Dat geev en Problem bi’t Överdragen vun de Anfraag. Gah trüch un versöök dat noch wedder.',
	'renamewiki_user-error-same-wiki_user' => 'De ole un ne’e Brukernaam sünd gliek.',
	'renamewiki_usersuccess' => "Brukernaam ''<nowiki>$1</nowiki>'' op ''<nowiki>$2</nowiki>'' ännert",
	'renamewiki_user-page-exists' => 'Siet $1 gifft dat al un kann nichautomaatsch överschreven warrn.',
	'renamewiki_user-page-moved' => 'Siet $1 schaven na $2.',
	'renamewiki_user-page-unmoved' => 'Siet $1 kunn nich na $2 schaven warrn.',
	'renamewiki_userlogpage' => 'Ännerte-Brukernaams-Logbook',
	'renamewiki_userlogpagetext' => 'Dit is dat Logbook för ännerte Brukernaams',
	'renamewiki_userlogentry' => 'hett „$1“ ne’en Naam „$2“ geven',
	'renamewiki_user-log' => '{{PLURAL:$1|1 Ännern|$1 Ännern}}. Grund: $2',
	'renamewiki_user-move-log' => "Siet bi dat Ännern vun’n Brukernaam ''[[wiki_user:$1|$1]]'' na ''[[wiki_user:$2|$2]]'' automaatsch schaven",
	'right-renamewiki_user' => 'Brukers ne’en Naam geven',
);

/** Nedersaksisch (Nedersaksisch)
 * @author Servien
 */
$messages['nds-nl'] = array(
	'renamewiki_user' => 'Gebruker herneumen',
	'renamewiki_user-linkoncontribs' => 'gebruker herneumen',
	'renamewiki_userold' => 'Gebrukersnaam noen',
	'renamewiki_usernew' => 'Nieje gebrukersnaam:',
	'renamewiki_userreason' => 'Reden veur t herneumen:',
	'renamewiki_usermove' => 'Herneum gebruker en gebrukersziejen (en ziejen die deronder vallen) naor de nieje naam.',
	'renamewiki_usersuppress' => 'Gien deurverwiezingen maken naor de nieje naam',
	'renamewiki_userreserve' => 'Veurkoemen dat de ouwe gebruker opniej eregistreerd wörden',
	'renamewiki_userwarnings' => 'Waorschuwingen:',
	'renamewiki_userconfirm' => 'Ja, herneum disse gebruker',
	'renamewiki_usersubmit' => 'Herneumen',
	'renamewiki_usererrordoesnotexist' => 'De gebruker "<nowiki>$1</nowiki>" besteet niet.',
	'renamewiki_usererrorexists' => 'De gebrukersnaam "<nowiki>$1</nowiki>" is al in gebruuk.',
	'renamewiki_usererrorinvalid' => 'De gebrukersnaam "<nowiki>$1</nowiki>" is ongeldig.',
	'renamewiki_usersuccess' => 'Gebruker "<nowiki>$1</nowiki>" is herneumd naor "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'De zied $1 besteet al en kan niet automaties overschreven wörden.',
	'renamewiki_user-page-moved' => 'De zied $1 is herneumd naor $2.',
	'renamewiki_user-page-unmoved' => 'De zied $1 kon niet herneumd wörden naor $2.',
	'renamewiki_userlogpage' => 'Logboek gebrukersnaamwiezigingen',
	'renamewiki_userlogpagetext' => 'Dit is n logboek mit wiezigingen van gebrukersnamen',
	'renamewiki_userlogentry' => 'hef $1 herneumd naor "$2"',
	'renamewiki_user-move-log' => 'Zied is automaties verplaotst bie t herneumen van de gebruker "[[wiki_user:$1|$1]]" naor "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'Gebrukers herneumen',
	'renamewiki_user-renamed-notice' => 'Disse gebrukersnaam is herneumd.
Hieronder vie-j t herneumlogboek as referensie.',
);

/** Nepali (नेपाली) */
$messages['ne'] = array(
	'renamewiki_userold' => 'अहिलेको प्रयोगकर्ता नाम:',
	'renamewiki_usernew' => 'नयाँ प्रयोगकर्ता नाम:',
	'renamewiki_usersubmit' => 'बुझाउने',
	'renamewiki_user-page-exists' => '$1 पृष्ठ पहिले देखि नै रहेको छ र स्वत: अधिलेखन गर्न सकिएन ।',
	'renamewiki_user-page-moved' => ' $1 पृष्ठलाई $2 मा सारियो ।',
	'renamewiki_user-page-unmoved' => '$1 पृष्ठलाई $2 मा सार्न सकिएन ।',
);

/** Dutch (Nederlands)
 * @author Effeietsanders
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'renamewiki_user' => 'Gebruiker hernoemen',
	'renamewiki_user-linkoncontribs' => 'gebruiker hernoemen',
	'renamewiki_user-linkoncontribs-text' => 'Deze gebruiker hernoemen',
	'renamewiki_user-desc' => "Voegt een [[Special:Renamewiki_user|speciale pagina]] toe om een gebruiker te hernoemen (u hebt hiervoor het recht ''renamewiki_user'' nodig)",
	'renamewiki_userold' => 'Huidige gebruikersnaam:',
	'renamewiki_usernew' => 'Nieuwe gebruikersnaam:',
	'renamewiki_userreason' => 'Reden voor hernoemen:',
	'renamewiki_usermove' => "De gebruikerspagina en overlegpagina (en eventuele subpagina's) hernoemen naar de nieuwe gebruikersnaam",
	'renamewiki_usersuppress' => 'Geen doorverwijzingen maken naar de nieuwe naam',
	'renamewiki_userreserve' => 'Voorkomen dat de oude gebruiker opnieuw wordt geregistreerd',
	'renamewiki_userwarnings' => 'Waarschuwingen:',
	'renamewiki_userconfirm' => 'Ja, de gebruiker hernoemen',
	'renamewiki_usersubmit' => 'Opslaan',
	'renamewiki_user-submit-blocklog' => 'Blokkeerlogboek voor gebruiker weergeven',
	'renamewiki_usererrordoesnotexist' => 'De gebruiker "<nowiki>$1</nowiki>" bestaat niet.',
	'renamewiki_usererrorexists' => 'De gebruiker "<nowiki>$1</nowiki>" bestaat al.',
	'renamewiki_usererrorinvalid' => 'De gebruikersnaam "<nowiki>$1</nowiki>" is ongeldig.',
	'renamewiki_user-error-request' => 'Er was een probleem bij het ontvangen van de aanvraag.
Ga terug en probeer het opnieuw.',
	'renamewiki_user-error-same-wiki_user' => 'U kunt geen gebruiker hernoemen naar dezelfde naam.',
	'renamewiki_usersuccess' => 'De gebruiker "<nowiki>$1</nowiki>" is hernoemd naar "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'De pagina $1 bestaat al en kan niet automatisch overschreven worden.',
	'renamewiki_user-page-moved' => 'De pagina $1 is hernoemd naar $2.',
	'renamewiki_user-page-unmoved' => 'De pagina $1 kon niet hernoemd worden naar $2.',
	'renamewiki_userlogpage' => 'Logboek gebruikersnaamwijzigingen',
	'renamewiki_userlogpagetext' => 'Hieronder staan gebruikersnamen die gewijzigd zijn.',
	'renamewiki_userlogentry' => 'heeft $1 hernoemd naar "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 bewerking|$1 bewerkingen}}. Reden: $2',
	'renamewiki_user-move-log' => 'Automatisch hernoemd bij het wijzigen van gebruiker "[[wiki_user:$1|$1]]" naar "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'gebruikers te hernoemen',
	'right-renamewiki_user' => 'Gebruikers hernoemen',
	'renamewiki_user-renamed-notice' => 'Deze gebruiker is hernoemd.
Relevante regels uit het logboek gebruikersnaamwijzigingen worden hieronder ter referentie weergegeven.',
);

/** Nederlands (informeel)‎ (Nederlands (informeel)‎)
 * @author Siebrand
 */
$messages['nl-informal'] = array(
	'renamewiki_user-error-same-wiki_user' => 'Je kunt geen gebruiker hernoemen naar dezelfde naam.',
);

/** Norwegian Nynorsk (norsk (nynorsk)‎)
 * @author Dittaeva
 * @author Gunnernett
 * @author Harald Khan
 * @author Njardarlogar
 * @author Ranveig
 */
$messages['nn'] = array(
	'renamewiki_user' => 'Døyp om brukar',
	'renamewiki_user-linkoncontribs' => 'døyp om brukar',
	'renamewiki_user-desc' => "Legg til ei [[Special:Renamewiki_user|spesialsida]] for å døypa om ein brukar (krev ''renamewiki_user''-rettar)",
	'renamewiki_userold' => 'Brukarnamn no:',
	'renamewiki_usernew' => 'Nytt brukarnamn:',
	'renamewiki_userreason' => 'Årsak for omdøyping:',
	'renamewiki_usermove' => 'Flytt brukar- og brukardiskusjonssider (og undersidene deira) til nytt namn',
	'renamewiki_usersuppress' => 'Ikkje opprett omdirigeringar til det nye namnet',
	'renamewiki_userreserve' => 'Blokker det gamle brukarnamnet for framtidig bruk',
	'renamewiki_userwarnings' => 'Åtvaringar:',
	'renamewiki_userconfirm' => 'Ja, endra namn på brukaren',
	'renamewiki_usersubmit' => 'Utfør',
	'renamewiki_usererrordoesnotexist' => 'Brukaren «<nowiki>$1</nowiki>» finst ikkje.',
	'renamewiki_usererrorexists' => 'Brukaren «<nowiki>$1</nowiki>» finst allereie.',
	'renamewiki_usererrorinvalid' => 'Brukarnamnet «<nowiki>$1</nowiki>» er ikkje gyldig.',
	'renamewiki_user-error-request' => 'Det var eit problem med å motta førespurnaden.
Gå attende og prøv på nytt.',
	'renamewiki_user-error-same-wiki_user' => 'Du kan ikkje gje ein brukar same namn som han/ho har frå før.',
	'renamewiki_usersuccess' => 'Brukaren «<nowiki>$1</nowiki>» har fått brukarnamnet endra til «<nowiki>$2</nowiki>»',
	'renamewiki_user-page-exists' => 'Sida $1 finst allereie og kan ikkje automatisk verta skrive over.',
	'renamewiki_user-page-moved' => 'Sida $1 har vorte flytta til $2.',
	'renamewiki_user-page-unmoved' => 'Sida $1 kunne ikkje verta flytta til $2.',
	'renamewiki_userlogpage' => 'Logg over brukarnamnendringar',
	'renamewiki_userlogpagetext' => 'Logg over endringar av brukarnamn',
	'renamewiki_userlogentry' => 'endra $1 til «$2»',
	'renamewiki_user-log' => '{{PLURAL:$1|eitt bidrag|$1 bidrag}}. Årsak: $2',
	'renamewiki_user-move-log' => 'Flytta sida automatisk under omdøyping av brukaren «[[wiki_user:$1|$1]]» til «[[wiki_user:$2|$2]]»',
	'right-renamewiki_user' => 'Døypa om brukarar',
	'renamewiki_user-renamed-notice' => 'Denne brukaren har fått nytt namn.
Til informasjon er omdøpingsloggen synt nedanfor.',
);

/** Northern Sotho (Sesotho sa Leboa)
 * @author Mohau
 */
$messages['nso'] = array(
	'renamewiki_user' => 'Fetola leina la mošomiši',
	'renamewiki_userold' => 'Leina la bjale la mošomiši:',
	'renamewiki_usernew' => 'Leina le lempsha la mošomiši:',
	'renamewiki_userreason' => 'Lebaka lago fetola leina:',
	'renamewiki_user-page-moved' => 'Letlakala $1 le hudušitšwe go $2',
);

/** Occitan (occitan)
 * @author Boulaur
 * @author Cedric31
 */
$messages['oc'] = array(
	'renamewiki_user' => "Tornar nomenar l'utilizaire",
	'renamewiki_user-linkoncontribs' => "tornar nomenar l'utilizaire",
	'renamewiki_user-linkoncontribs-text' => "Tornar nomenar l'utilizaire",
	'renamewiki_user-desc' => "Torna nomenar un utilizaire (necessita los dreches de ''renamewiki_user'')",
	'renamewiki_userold' => "Nom actual de l'utilizaire :",
	'renamewiki_usernew' => "Nom novèl de l'utilizaire :",
	'renamewiki_userreason' => 'Motiu del cambiament de nom :',
	'renamewiki_usermove' => 'Desplaçar totas las paginas de l’utilizaire cap al nom novèl',
	'renamewiki_userreserve' => 'Reservar lo nom ancian per un usatge futur',
	'renamewiki_userwarnings' => 'Avertiments :',
	'renamewiki_userconfirm' => 'Òc, tornar nomenar l’utilizaire',
	'renamewiki_usersubmit' => 'Sometre',
	'renamewiki_usererrordoesnotexist' => "Lo nom d'utilizaire « <nowiki>$1</nowiki> » es pas valid",
	'renamewiki_usererrorexists' => "Lo nom d'utilizaire « <nowiki>$1</nowiki> » existís ja",
	'renamewiki_usererrorinvalid' => "Lo nom d'utilizaire « <nowiki>$1</nowiki> » existís pas",
	'renamewiki_user-error-request' => 'Un problèma existís amb la recepcion de la requèsta. Tornatz en rèire e ensajatz tornamai.',
	'renamewiki_user-error-same-wiki_user' => 'Podètz pas tornar nomenar un utilizaire amb la meteissa causa deperabans.',
	'renamewiki_usersuccess' => "L'utilizaire « <nowiki>$1</nowiki> » es plan estat renomenat en « <nowiki>$2</nowiki> »",
	'renamewiki_user-page-exists' => 'La pagina $1 existís ja e pòt pas èsser remplaçada automaticament.',
	'renamewiki_user-page-moved' => 'La pagina $1 es estada desplaçada cap a $2.',
	'renamewiki_user-page-unmoved' => 'La pagina $1 pòt pas èsser renomenada en $2.',
	'renamewiki_userlogpage' => "Istoric dels cambiaments de nom d'utilizaire",
	'renamewiki_userlogpagetext' => "Aquò es l'istoric dels cambiaments de nom dels utilizaires",
	'renamewiki_userlogentry' => 'a renomenat $1 en "$2"',
	'renamewiki_user-log' => '$1 {{PLURAL:$1|edicion|edicions}}. Motiu : $2',
	'renamewiki_user-move-log' => 'Pagina desplaçada automaticament al moment del cambiament de nom de l’utilizaire "[[wiki_user:$1|$1]]" en "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => "Tornar nomenar d'utilizaires",
	'renamewiki_user-renamed-notice' => 'Aqueste utilizaire es estat renomenat.
Lo jornal dels cambiaments de noms es disponible çaijós per informacion.',
);

/** Oriya (ଓଡ଼ିଆ)
 * @author Odisha1
 * @author Psubhashish
 */
$messages['or'] = array(
	'renamewiki_user' => 'ସଭ୍ୟଙ୍କ ନାମଟି ବଦଳାଇବେ',
	'renamewiki_user-linkoncontribs' => 'ସଭ୍ୟଙ୍କ ନାମଟି ବଦଳାଇବେ',
	'renamewiki_user-linkoncontribs-text' => 'ଏହି ସଭ୍ୟଙ୍କର ନାମ ବଦଳାଇବେ',
	'renamewiki_user-desc' => "ଜଣେ ସଭ୍ୟଙ୍କର ନାମ ବଦଳାଇବା ପାଇଁ ଏକ [[Special:Renamewiki_user|ବିଶେଷ ପୃଷ୍ଠା]] ଯୋଡ଼ିଥାଏ ।(''ନୂଆ ନାମକରଣ'' ଅଧିକାର ଲୋଡ଼ା)",
	'renamewiki_userold' => 'ଏବେକାର ଇଉଜର ନାମ:',
	'renamewiki_usernew' => 'ନୂଆ ଇଉଜର ନାମ:',
	'renamewiki_userreason' => 'ନାମ ବଦଳାଇବାର କାରଣ:',
	'renamewiki_usermove' => 'ସଭ୍ୟ, ତାହାଙ୍କର ଆଲୋଚନା ପୃଷ୍ଠାମାନଙ୍କୁ (ତଥା ସାନପୃଷ୍ଠାମାନଙ୍କୁ)ନୂଆ ନାମକୁ ଘୁଞ୍ଚାଇବେ',
	'renamewiki_usersuppress' => 'ନୂଆ ନାମକୁ ପୁନପ୍ରେରଣ କରନ୍ତୁ ନାହିଁ',
	'renamewiki_userreserve' => 'ଭବିଷ୍ୟତ ବ୍ୟବହାରରେ ପୁରୁଣା ଇଉଜର ନାମକୁ ଅଟକାଇ ଦିଅନ୍ତୁ',
	'renamewiki_userwarnings' => 'ଚେତାବନୀ:',
	'renamewiki_userconfirm' => 'ହଁ, ସଭ୍ୟଙ୍କ ନାମ ବଦଳାଇ ଦେବେ',
	'renamewiki_usersubmit' => 'ଦାଖଲକରିବା',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" ନାମକ ସଭ୍ୟଜଣକ ଏଠାରେ ନାହାନ୍ତି ।',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" ନାମକ ସଭ୍ୟଜଣକ ଆଗରୁ ଅଛନ୍ତି ।',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" ଇଉଜର ନାମଟି ଅଚଳ ଅଟେ ।',
	'renamewiki_user-error-request' => 'ଅନୁରୋଧ ଗ୍ରହଣ କରିବାରେ ଏକ ଅସୁବିଧା ହେଲା ।
ଦୟାକରି ପଛକୁ ଫେରି ଆଉଥରେ ଚେଷ୍ଟା କରନ୍ତୁ ।',
	'renamewiki_user-error-same-wiki_user' => 'ଆଗ ଭଳି ଆପଣ ଜଣେ ସଭ୍ୟଙ୍କର ନାମ ବଦଳାଇପାରିବେ ନାହିଁ ।',
	'renamewiki_usersuccess' => '"<nowiki>$1</nowiki>" ସଭ୍ୟଙ୍କ ନାମ "<nowiki>$2</nowiki>"କୁ ବଦଳାଗଲା ।',
	'renamewiki_user-page-exists' => '$1 ପୃଷ୍ଠାଟି ଆଗରୁ ଅଛି ଓ ଆଉଥରେ ଲେଖାଯାଇପାରିବ ନାହିଁ ।',
	'renamewiki_user-page-moved' => '$1 ପୃଷ୍ଠାଟିକୁ $2କୁ ଘୁଞ୍ଚାଇ ଦିଆଗଲା ।',
	'renamewiki_user-page-unmoved' => '$1 ପୃଷ୍ଠାଟି $2କୁ ଘୁଞ୍ଚାଯାଇ ପାରିବ ନାହିଁ ।',
	'renamewiki_userlogpage' => 'ସଭ୍ୟ ନାମବଦଳ ଇତିହାସ',
	'renamewiki_userlogpagetext' => 'ସଭ୍ୟଙ୍କ ନାମ ବଦଳର ଏହା ଏକ ଇତିହାସ ।',
	'renamewiki_userlogentry' => '$1 ରୁ "$2" କୁ ନାମ ବଦଳାଗଲା',
	'renamewiki_user-log' => '{{PLURAL:$1|ସମ୍ପାଦନାଟିଏ|$1 ଗୋଟି ସମ୍ପାଦନା}} । କାରଣ: $2',
	'renamewiki_user-move-log' => 'ସଭ୍ୟ "[[wiki_user:$1|$1]]"ରୁ "[[wiki_user:$2|$2]]"କୁ ନାମ ବଦଳ କଲାବେଳେ ବେଳେ ଛାଏଁ ଛାଏଁ ପୃଷ୍ଠାଟି ଘୁଞ୍ଚାଇ ଦିଆଗଲା',
	'right-renamewiki_user' => 'ସଭ୍ୟମାନଙ୍କ ନାମଟି ବଦଳାଇବେ',
	'renamewiki_user-renamed-notice' => 'ଏହି ସଭ୍ୟଙ୍କ ନାମ ବଦଳାଯାଇଅଛି ।
ତଳେ ଅବଗତି ନିମନ୍ତେ ନାମ ବଦଳ ଇତିହାସ ଦିଆଗଲା ।',
);

/** Ossetic (Ирон)
 * @author Amikeco
 */
$messages['os'] = array(
	'renamewiki_user' => 'Архайæджы ном баив',
	'renamewiki_userold' => 'Ныры ном:',
	'renamewiki_usernew' => 'Ног ном:',
	'renamewiki_userreason' => 'Ном ивыны аххос:',
	'renamewiki_usersubmit' => 'Афтæ уæд',
	'renamewiki_userlogpage' => 'Архайджыты нæмттæ ивыны лог',
);

/** Picard (Picard)
 * @author Geoleplubo
 */
$messages['pcd'] = array(
	'renamewiki_user' => "Canger ch'nom d'uzeu",
	'renamewiki_usernew' => 'Nouvieu nom dechl uzeu',
	'renamewiki_userreason' => "Motif dech canjemint d'nom",
	'renamewiki_userwarnings' => 'Afute ! :',
	'renamewiki_userconfirm' => 'Oui, érlonmer echl uzeu',
	'renamewiki_usererrorinvalid' => 'Ech nom  "<nowiki>$1</nowiki>" est non-val.',
	'renamewiki_usersuccess' => 'Echl uzeu "<nowiki>$1</nowiki>" o té érlonmé "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-moved' => "L'pache $1 o té déplachée dsus $2.",
	'renamewiki_user-page-unmoved' => "L'pache $1 ale n'put poin éte déplachée su $2.",
	'renamewiki_userlogpage' => "Jornal d'chés canjemints éd chés noms d'uzeus",
	'renamewiki_userlogpagetext' => "Ch'est un jornal éd chés canjemints d'chés noms d'uzeus.",
	'renamewiki_userlogentry' => '$1 est érlonmé in "$2"',
	'right-renamewiki_user' => 'Érlonmer chés uzeus',
);

/** Deitsch (Deitsch)
 * @author Xqt
 */
$messages['pdc'] = array(
	'renamewiki_user' => 'Naame vum Yuwiki_user ennere',
	'renamewiki_userold' => 'Current Yuwiki_usernaame:',
	'renamewiki_usernew' => 'Nei Yuwiki_user-Naame',
	'renamewiki_userreason' => 'Grund:',
	'renamewiki_userwarnings' => 'Warninge:',
	'renamewiki_userlogentry' => 'hot „$1“ nooch „$2“ gennert',
	'renamewiki_user-log' => '{{PLURAL:$1|1 Ennering|$1 Enneringe}}. Grund: $2',
);

/** Pälzisch (Pälzisch)
 * @author SPS
 */
$messages['pfl'] = array(
	'renamewiki_usersubmit' => 'Benutzer umbenenne',
);

/** Polish (polski)
 * @author BeginaFelicysym
 * @author Derbeth
 * @author Leinad
 * @author Maikking
 * @author Nux
 * @author Remedios44
 * @author Sovq
 * @author Sp5uhe
 * @author WarX
 * @author Wpedzich
 */
$messages['pl'] = array(
	'renamewiki_user' => 'Zmiana nazwy użytkownika',
	'renamewiki_user-linkoncontribs' => 'zmień nazwę użytkownika',
	'renamewiki_user-linkoncontribs-text' => 'Zmień nazwę tego użytkownika',
	'renamewiki_user-desc' => "Zmiana nazwy użytkownika (wymaga posiadania uprawnień ''renamewiki_user'')",
	'renamewiki_userold' => 'Obecna nazwa użytkownika:',
	'renamewiki_usernew' => 'Nowa nazwa użytkownika:',
	'renamewiki_userreason' => 'Przyczyna zmiany nazwy:',
	'renamewiki_usermove' => 'Przeniesienie strony osobistej i strony dyskusji użytkownika (oraz ich podstron) pod nową nazwę użytkownika',
	'renamewiki_usersuppress' => 'Nie twórz przekierowania do nowej nazwy',
	'renamewiki_userreserve' => 'Zablokuj starą nazwę użytkownika przed możliwością użycia jej',
	'renamewiki_userwarnings' => 'Ostrzeżenia:',
	'renamewiki_userconfirm' => 'Zmień nazwę użytkownika',
	'renamewiki_usersubmit' => 'Zmień',
	'renamewiki_user-submit-blocklog' => 'Pokaż rejestr blokad użytkownika',
	'renamewiki_usererrordoesnotexist' => 'Użytkownik „<nowiki>$1</nowiki>” nie istnieje',
	'renamewiki_usererrorexists' => 'Użytkownik „<nowiki>$1</nowiki>” już istnieje',
	'renamewiki_usererrorinvalid' => 'Niepoprawna nazwa użytkownika „<nowiki>$1</nowiki>”',
	'renamewiki_user-error-request' => 'Wystąpił problem z odbiorem żądania.
Cofnij się i spróbuj jeszcze raz.',
	'renamewiki_user-error-same-wiki_user' => 'Nie możesz zmienić nazwy użytkownika na taką samą jaka była wcześniej.',
	'renamewiki_usersuccess' => 'Nazwa użytkownika „<nowiki>$1</nowiki>” została zmieniona na „<nowiki>$2</nowiki>”',
	'renamewiki_user-page-exists' => 'Strona „$1” już istnieje i nie może być automatycznie nadpisana.',
	'renamewiki_user-page-moved' => 'Strona „$1” została przeniesiona pod nazwę „$2”.',
	'renamewiki_user-page-unmoved' => 'Strona „$1” nie mogła zostać przeniesiona pod nazwę „$2”.',
	'renamewiki_userlogpage' => 'Zmiany nazw użytkowników',
	'renamewiki_userlogpagetext' => 'To jest rejestr zmian nazw użytkowników',
	'renamewiki_userlogentry' => 'zmienił nazwę użytkownika $1 na „$2”',
	'renamewiki_user-log' => '$1 {{PLURAL:$1|edycja|edycje|edycji}}. Powód: $2',
	'renamewiki_user-move-log' => 'Automatyczne przeniesienie stron użytkownika po zmianie nazwy konta z „[[wiki_user:$1|$1]]” na „[[wiki_user:$2|$2]]”',
	'action-renamewiki_user' => 'zmiana nazw użytkowników',
	'right-renamewiki_user' => 'Zmiana nazw kont użytkowników',
	'renamewiki_user-renamed-notice' => 'Nazwa konta {{GENDER:$1|tego użytkownika|tej użytkowniczki|użytkownika(‐czki)}} została zmieniona.
Rejestr zmian nazw kont użytkowników znajduje się poniżej.',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Bèrto 'd Sèra
 * @author Dragonòt
 */
$messages['pms'] = array(
	'renamewiki_user' => "Arbatié n'utent",
	'renamewiki_user-linkoncontribs' => "arbatié n'utent",
	'renamewiki_user-linkoncontribs-text' => "Arbatié st'utent-sì",
	'renamewiki_user-desc' => "A gionta na [[Special:Renamewiki_user|pàgina special]] për arnominé n'utent (a-i é dabzògn dël drit ''renamewiki_user'')",
	'renamewiki_userold' => 'Stranòm corent:',
	'renamewiki_usernew' => 'Stranòm neuv:',
	'renamewiki_userreason' => "Rason ch'as cambia stranòm:",
	'renamewiki_usermove' => 'Tramuda ëdcò la pàgina utent e cola dle ciaciarade (con tute soe sotapàgine) a lë stranòm neuv',
	'renamewiki_usersuppress' => 'Creé nen na ridiression al nòm neuv',
	'renamewiki_userreserve' => 'Blòca lë stanòm vej da future utilisassion',
	'renamewiki_userwarnings' => 'Atension:',
	'renamewiki_userconfirm' => "É!, arnòmina l'utent",
	'renamewiki_usersubmit' => 'Falo',
	'renamewiki_user-submit-blocklog' => "Smon-e ël registr dij blocage për l'utent",
	'renamewiki_usererrordoesnotexist' => 'A-i é pa gnun utent ch\'as ës-ciama "<nowiki>$1</nowiki>"',
	'renamewiki_usererrorexists' => 'N\'utent ch\'as ës-ciama "<nowiki>$1</nowiki>" a-i é già',
	'renamewiki_usererrorinvalid' => 'Lë stranòm "<nowiki>$1</nowiki>" a l\'é nen bon',
	'renamewiki_user-error-request' => "A l'é stàit-ie un problema con l'esecussion ëd l'arcesta.
Për piasì torna andré e preuva torna.",
	'renamewiki_user-error-same-wiki_user' => "It peule pa arnominé n'utent con ël midem nòm ëd prima.",
	'renamewiki_usersuccess' => 'L\'utent "<nowiki>$1</nowiki>" a l\'é stait arbatià an "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => "La pàgina $1 a-i é già e as peul nen passe-ie dzora n'aotomàtich.",
	'renamewiki_user-page-moved' => "La pàgina $1 a l'ha fait San Martin a $2.",
	'renamewiki_user-page-unmoved' => "La pàgina $1 a l'é pa podusse tramudé a $2.",
	'renamewiki_userlogpage' => "Registr dj'arbatiagi",
	'renamewiki_userlogpagetext' => "Sossì a l'é un registr dle modìfiche djë stranòm dj'utent",
	'renamewiki_userlogentry' => 'a l\'ha arbatià $1 an "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 modìfica|$1 modìfiche}}. Rason: $2',
	'renamewiki_user-move-log' => 'Pàgina utent tramudà n\'aotomàtich damëntrè ch\'as arbatiava "[[wiki_user:$1|$1]]" an "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => "arbatié j'utent",
	'right-renamewiki_user' => "Arnòmina j'utent",
	'renamewiki_user-renamed-notice' => "St'utent-sì a l'é stàit arnominà.
Ël registr ëd l'arnòmina a l'é dàit sota për arferiment.",
);

/** Western Punjabi (پنجابی)
 * @author Khalid Mahmood
 */
$messages['pnb'] = array(
	'renamewiki_user' => 'ورتن والے دا ہور ناں',
	'renamewiki_user-linkoncontribs' => 'ورتن والے دا ہور ناں',
	'renamewiki_user-linkoncontribs-text' => 'ایس ورتن والے دا ہور ناں رکھو',
	'renamewiki_user-desc' => "جوڑدا اے اک [[Special:Renamewiki_user|خاص صفہ]] اک ورتن والے نوں ہور ناں دین لئی ( ''renamewiki_user'' حق دی لوڑ اے۔)",
	'renamewiki_userold' => 'ہن والا ورتن والا ناں:',
	'renamewiki_usernew' => 'نواں ورتن والا ناں:',
	'renamewiki_userreason' => 'ہور ناں رکھن دی وجہ:',
	'renamewiki_usermove' => 'ورتن تے گل بات صفے نوں تے نال دے نکیاں صفیاں نوں نویں ناں ول لے چلو۔',
	'renamewiki_usersuppress' => 'ایس نویں ناں نال ریڈائرکٹ ناں بناؤ۔',
	'renamewiki_userreserve' => 'پرانے ورتن والے ناں نوں اگے ورتے جان توں روکو',
	'renamewiki_userwarnings' => 'خبردار',
	'renamewiki_userconfirm' => 'ہاں، ورتن والے دا فیر ناں رکھو',
	'renamewiki_usersubmit' => 'پیش کرو',
	'renamewiki_usererrordoesnotexist' => 'ورتنوالا "<nowiki>$1</nowiki>" ہے ای نئیں۔',
	'renamewiki_usererrorexists' => 'ورتنوالا "<nowiki>$1</nowiki>" پہلے ای ہیگا اے۔',
	'renamewiki_usererrorinvalid' => 'ورتن ناں "<nowiki>$1</nowiki>" نئیں چل سکدا۔',
	'renamewiki_user-error-request' => 'گل منن چ مسلہ اے۔ مہربانی کرکے پچھے جاؤ تے فیر کوشش کرو۔',
	'renamewiki_user-error-same-wiki_user' => 'تسیں فیر پہلے وانگوں اک ورتن والے دا ناں فیر نئیں رکھ سکدے۔',
	'renamewiki_usersuccess' => 'ورتن والا "<nowiki>$1</nowiki>" دا ناں بدل کے "<nowiki>$1</nowiki>" رکھ دتا گیا اے۔',
	'renamewiki_user-page-exists' => 'صفہ $1 پہلے ای ہیگا اے تے ایدے تے اپنے آپ نئیں لکھیا جاسکدا۔',
	'renamewiki_user-page-moved' => 'صفہ $1 نوں $2 ول لجایا گیا اے۔',
	'renamewiki_user-page-unmoved' => 'صفہ $1 ، $2 ول نئیں لجایا جاسکدا۔',
	'renamewiki_userlogpage' => 'ورتن ہور ناں لاگ',
	'renamewiki_userlogpagetext' => 'ورتن ناواں چ تبدیلیاں دی اے لاگ اے۔',
	'renamewiki_userlogentry' => '$1 بدل کے "$2" رکھیا گیا۔',
	'renamewiki_user-log' => '{{PLURAL:$1|1 تبدیلی|1$ تبدیلیاں}}. وجہ: 2$',
	'renamewiki_user-move-log' => 'اپنے آپ صفے ٹرے "[[wiki_user:$1|$1]]" دا ناں "[[wiki_user:$2|$2]]" پلٹدیاں ہویاں',
	'right-renamewiki_user' => 'ورتن والے دا ہور ناں',
	'renamewiki_user-renamed-notice' => 'ایس ورتن والے دا ناں بدلیا گیا اے۔
ناں بدلن والی لاگ اتے پتے لئی تھلے دتی گئی اے۔',
);

/** Pashto (پښتو)
 * @author Ahmed-Najib-Biabani-Ibrahimkhel
 */
$messages['ps'] = array(
	'renamewiki_user' => 'کارن-نوم بدلول',
	'renamewiki_user-linkoncontribs' => 'د کارن نوم بدلول',
	'renamewiki_user-linkoncontribs-text' => 'د دې کارن نوم بدلول',
	'renamewiki_userold' => 'اوسنی کارن-نوم:',
	'renamewiki_usernew' => 'نوی کارن-نوم:',
	'renamewiki_userreason' => 'د نوم د بدلون سبب:',
	'renamewiki_userwarnings' => 'ګواښنې:',
	'renamewiki_userconfirm' => 'هو، کارن-نوم بدلوم',
	'renamewiki_usersubmit' => 'سپارل',
	'renamewiki_usererrordoesnotexist' => 'د "<nowiki>$1</nowiki>" په نامه کوم کارن نه شته.',
	'renamewiki_usererrorexists' => 'د "<nowiki>$1</nowiki>" په نامه يو کارن له پخوا نه شته.',
	'renamewiki_usererrorinvalid' => 'د "<nowiki>$1</nowiki>" کارن نوم سم نه دی.',
	'renamewiki_user-error-request' => 'د غوښتنې په ترلاسه کولو کې يوه ستونزه راپېښه شوه.
مهرباني وکړی بېرته پرشا ولاړ شی او يو ځل بيا پرې کوښښ وکړی.',
	'renamewiki_user-page-moved' => 'د $1 مخ $2 ته ولېږدل شو.',
	'renamewiki_userlogpage' => 'د کارن-نوم يادښت',
	'renamewiki_userlogentry' => 'د $1 نوم، "$2" ته بدل شو',
	'renamewiki_user-log' => '{{PLURAL:$1|1 سمون|$1 سمونونه}}. سبب: $2',
	'action-renamewiki_user' => 'کارن-نومونه بدلول',
	'right-renamewiki_user' => 'کارن-نومونه بدلول',
);

/** Portuguese (português)
 * @author 555
 * @author Giro720
 * @author Hamilton Abreu
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'renamewiki_user' => 'Alterar o nome do utilizador',
	'renamewiki_user-linkoncontribs' => 'alterar nome do utilizador',
	'renamewiki_user-linkoncontribs-text' => 'Alterar o nome deste utilizador',
	'renamewiki_user-desc' => "[[Special:Renamewiki_user|Página especial]] para alterar o nome de um utilizador (requer o privilégio ''renamewiki_user'')",
	'renamewiki_userold' => 'Nome de utilizador actual:',
	'renamewiki_usernew' => 'Novo nome de utilizador:',
	'renamewiki_userreason' => 'Motivo da alteração de nome:',
	'renamewiki_usermove' => 'Mover as páginas e subpáginas de utilizador e as respectivas discussões para o novo nome',
	'renamewiki_usersuppress' => 'Não criar redireccionamentos para o novo nome',
	'renamewiki_userreserve' => 'Impedir novos usos do antigo nome de utilizador',
	'renamewiki_userwarnings' => 'Alertas:',
	'renamewiki_userconfirm' => 'Sim, alterar o nome do utilizador',
	'renamewiki_usersubmit' => 'Enviar',
	'renamewiki_user-submit-blocklog' => 'Mostrar o registo de bloqueios do utilizador',
	'renamewiki_usererrordoesnotexist' => 'O utilizador "<nowiki>$1</nowiki>" não existe.',
	'renamewiki_usererrorexists' => 'Já existe um utilizador "<nowiki>$1</nowiki>".',
	'renamewiki_usererrorinvalid' => 'O nome de utilizador "<nowiki>$1</nowiki>" é inválido.',
	'renamewiki_user-error-request' => 'Houve um problema ao receber este pedido.
Volte atrás e tente de novo, por favor.',
	'renamewiki_user-error-same-wiki_user' => 'Não é possível alterar o nome de um utilizador para o nome anterior.',
	'renamewiki_usersuccess' => 'O nome do utilizador "<nowiki>$1</nowiki>" foi alterado para "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Já existe a página $1. Não é possível sobrescrever automaticamente.',
	'renamewiki_user-page-moved' => 'A página $1 foi movida para $2.',
	'renamewiki_user-page-unmoved' => 'Não foi possível mover a página $1 para $2.',
	'renamewiki_userlogpage' => 'Registo de alteração do nome de utilizadores',
	'renamewiki_userlogpagetext' => 'Este é um registo de alterações efectuadas a nomes de utilizadores.',
	'renamewiki_userlogentry' => 'mudou nome $1 para "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 edição|$1 edições}}. Motivo: $2',
	'renamewiki_user-move-log' => 'Página movida automaticamente ao alterar o nome do utilizador "[[wiki_user:$1|$1]]" para "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'alterar nomes de utilizadores',
	'right-renamewiki_user' => 'Alterar nomes de utilizadores',
	'renamewiki_user-renamed-notice' => 'Este nome de utilizador foi alterado.
É apresentado abaixo o registo de alteração do nome de utilizadores.',
);

/** Brazilian Portuguese (português do Brasil)
 * @author 555
 * @author Giro720
 */
$messages['pt-br'] = array(
	'renamewiki_user' => 'Renomear usuário',
	'renamewiki_user-linkoncontribs' => 'renomear usuário',
	'renamewiki_user-linkoncontribs-text' => 'excluir este usuário',
	'renamewiki_user-desc' => "Adiciona uma [[Special:Renamewiki_user|página especial]] para renomear um usuário (requer privilégio ''renamewiki_user'')",
	'renamewiki_userold' => 'Nome de usuário atual:',
	'renamewiki_usernew' => 'Novo nome de usuário:',
	'renamewiki_userreason' => 'Motivo da alteração de nome:',
	'renamewiki_usermove' => 'Mover as páginas de usuário, páginas de discussão de usuário e sub-páginas para o novo nome',
	'renamewiki_usersuppress' => 'Não criar redirecionamentos para o novo nome',
	'renamewiki_userreserve' => 'Impedir novos usos do antigo nome de usuário',
	'renamewiki_userwarnings' => 'Alertas:',
	'renamewiki_userconfirm' => 'Sim, renomeie o usuário',
	'renamewiki_usersubmit' => 'Enviar',
	'renamewiki_usererrordoesnotexist' => 'Não existe um usuário "<nowiki>$1</nowiki>".',
	'renamewiki_usererrorexists' => 'Já existe um usuário "<nowiki>$1</nowiki>".',
	'renamewiki_usererrorinvalid' => 'O nome de usuário "<nowiki>$1</nowiki>" é inválido.',
	'renamewiki_user-error-request' => 'Houve um problema ao receber este pedido.
Retorne e tente novamente.',
	'renamewiki_user-error-same-wiki_user' => 'Não é possível renomear um usuário para o nome anterior.',
	'renamewiki_usersuccess' => 'O usuário "<nowiki>$1</nowiki>" foi renomeado para "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Já existe a página $1. Não é possível sobrescrever automaticamente.',
	'renamewiki_user-page-moved' => 'A página $1 foi movida com sucesso para $2.',
	'renamewiki_user-page-unmoved' => 'Não foi possível mover a página $1 para $2.',
	'renamewiki_userlogpage' => 'Registro de renomeação de usuários',
	'renamewiki_userlogpagetext' => 'Este é um registro de alterações efetuadas em nomes de usuários.',
	'renamewiki_userlogentry' => 'renomeou $1 para "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 edição|$1 edições}}. Motivo: $2',
	'renamewiki_user-move-log' => 'Páginas foram movidas automaticamente ao renomear o usuário "[[wiki_user:$1|$1]]" para "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'Renomear usuários',
	'renamewiki_user-renamed-notice' => 'Este usuário foi renomeado.
O registro de renomeação é fornecido abaixo para referência.',
);

/** Quechua (Runa Simi)
 * @author AlimanRuna
 */
$messages['qu'] = array(
	'renamewiki_user' => 'Ruraqpa sutinta hukchay',
	'renamewiki_user-linkoncontribs' => 'ruraqpa sutinta hukchay',
	'renamewiki_user-linkoncontribs-text' => 'Kay ruraqpa sutinta hukchay',
	'renamewiki_user-desc' => "[[Special:Renamewiki_user|Sapaq p'anqatam]] yapan ruraqpa sutinta hukchanapaq (''renamewiki_user'' hayñi kana tiyan)",
	'renamewiki_userold' => 'Kunan ruraqpa sutin:',
	'renamewiki_usernew' => 'Musuq ruraqpa sutin:',
	'renamewiki_userreason' => 'Imarayku ruraqpa sutinta hukchasqa:',
	'renamewiki_usermove' => "Ruraqpa p'anqanta, rimachinanta (urin p'anqankunatapas) musuq sutinman astay",
	'renamewiki_usersuppress' => 'Musuq sutiman ama pusapunata kamariychu',
	'renamewiki_userreserve' => "Ruraqpa mawk'a sutinta qhipaq pacha suti kanamanta hark'ay",
	'renamewiki_userwarnings' => 'Yuyampaykuna:',
	'renamewiki_userconfirm' => 'Arí, ruraqpa sutinta hukchay',
	'renamewiki_usersubmit' => 'Kachay',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" sutiyuq ruraqqa manam kanchu.',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" sutiyuq ruraqqa kachkanñam.',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" nisqa sutiqa manam allinchu.',
	'renamewiki_user-error-request' => 'Manam atinichu mañasqaykita chaskiyta.  Ama hina kaspa, ñawpaqman kutimuspa musuqmanta ruraykachay.',
	'renamewiki_user-error-same-wiki_user' => 'Manam atinkichu ruraqpa sutinta ñawpaq suti hinalla sutinman hukchayta.',
	'renamewiki_usersuccess' => 'Ruraqpa "<nowiki>$1</nowiki>" nisqa sutinqa "<nowiki>$2</nowiki>" nisqa sutinman hukchasqañam.',
	'renamewiki_user-page-exists' => '"<nowiki>$1</nowiki>" sutiyuq p\'anqaqa kachkanñam. Manam atinallachu kikinmanta huknachay.',
	'renamewiki_user-page-moved' => '"<nowiki>$1</nowiki>" ñawpa sutiyuq ruraqpa p\'anqanqa "<nowiki>$2</nowiki>" nisqa musuq p\'anqanman astasqañam.',
	'renamewiki_user-page-unmoved' => 'Manam atinichu "<nowiki>$1</nowiki>" ñawpa sutiyuq ruraqpa p\'anqanta "<nowiki>$2</nowiki>" nisqa musuq p\'anqanman astayta.',
	'renamewiki_userlogpage' => "Ruraqpa sutin hukchay hallch'a",
	'renamewiki_userlogpagetext' => "Kayqa ruraqkunap sutinkunata hukchaymanta hallch'am",
	'renamewiki_userlogentry' => '$1-pa sutinta "$2" sutiman hukchasqa',
	'renamewiki_user-log' => "{{PLURAL:$1|1 llamk'apusqa|$1 llamk'apusqakuna}}, kayrayku: $2",
	'renamewiki_user-move-log' => '"[[wiki_user:$1|$1]]" ruraqpa sutinta "[[wiki_user:$2|$2]]" sutiman hukchaspa kikinmanta ruraqpa p\'anqatapas astan',
	'right-renamewiki_user' => 'Ruraqpa sutinkunata hukchay',
	'renamewiki_user-renamed-notice' => "Kay ruraqpa sutinqa hukchasqañam.
Kay qatiqpiqa hukchay hallch'atam rikunki.",
);

/** Romani (Romani)
 * @author Desiphral
 */
$messages['rmy'] = array(
	'renamewiki_usersubmit' => 'De le jeneske aver nav',
);

/** Romanian (română)
 * @author Cin
 * @author Emily
 * @author Firilacroco
 * @author KlaudiuMihaila
 * @author Memo18
 * @author Minisarm
 * @author Stelistcristi
 */
$messages['ro'] = array(
	'renamewiki_user' => 'Redenumire utilizator',
	'renamewiki_user-linkoncontribs' => 'redenumirea utilizatorului',
	'renamewiki_user-linkoncontribs-text' => 'Redenumeşte acest utilizator',
	'renamewiki_user-desc' => "Adaugă o [[Special:Renamewiki_user|pagină specială]] pentru a redenumi un utilizator (necesită drept de ''renamewiki_user'')",
	'renamewiki_userold' => 'Numele de utilizator existent:',
	'renamewiki_usernew' => 'Noul nume de utilizator:',
	'renamewiki_userreason' => 'Motivul schimbării numelui:',
	'renamewiki_usermove' => 'Redenumește pagina de utilizator și pagina de discuții (și subpaginile lor) la noul nume',
	'renamewiki_usersuppress' => 'Nu crea redirecționări către noul nume',
	'renamewiki_userreserve' => 'Blochează vechiul nume de utilizator pentru utilizări viitoare',
	'renamewiki_userwarnings' => 'Avertizări:',
	'renamewiki_userconfirm' => 'Da, redenumește utilizatorul',
	'renamewiki_usersubmit' => 'Trimite',
	'renamewiki_user-submit-blocklog' => 'Arată jurnalul blocărilor utilizatorului',
	'renamewiki_usererrordoesnotexist' => 'Utilizatorul „<nowiki>$1</nowiki>” nu există.',
	'renamewiki_usererrorexists' => 'Utilizatorul „<nowiki>$1</nowiki>” există deja.',
	'renamewiki_usererrorinvalid' => 'Numele de utilizator „<nowiki>$1</nowiki>” este invalid.',
	'renamewiki_user-error-request' => 'Am întâmpinat o problemă în procesul de recepționare a cererii.
Vă rugăm să vă întoarceți și să reîncercați.',
	'renamewiki_user-error-same-wiki_user' => 'Nu puteți redenumi un utilizator la același nume ca și înainte.',
	'renamewiki_usersuccess' => 'Utilizatorul „$1” a fost redenumit în „$2”',
	'renamewiki_user-page-exists' => 'Pagina $1 există deja și nu poate fi suprascrisă automat.',
	'renamewiki_user-page-moved' => 'Pagina $1 a fost redenumită în $2.',
	'renamewiki_user-page-unmoved' => 'Pagina $1 nu poate fi redenumită în $2.',
	'renamewiki_userlogpage' => 'Jurnal redenumiri utilizatori',
	'renamewiki_userlogpagetext' => 'Acesta este un jurnal al modificărilor de nume de utilizator',
	'renamewiki_userlogentry' => 'a redenumit $1 în „$2”',
	'renamewiki_user-log' => '{{PLURAL:$1|o contribuție|$1 contribuții}}. Motiv: $2',
	'renamewiki_user-move-log' => 'Pagină mutată automat la redenumirea utilizatorului de la „[[wiki_user:$1|$1]]” la „[[wiki_user:$2|$2]]”',
	'action-renamewiki_user' => 'redenumește utilizatori',
	'right-renamewiki_user' => 'Redenumește utilizatori',
	'renamewiki_user-renamed-notice' => 'Acestui utilizator i-a fost schimbat numele.
Jurnalul redenumirilor este furnizat mai jos pentru referință.',
);

/** tarandíne (tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'renamewiki_user' => "Renomene l'utende",
	'renamewiki_user-linkoncontribs' => "renomene l'utende",
	'renamewiki_user-linkoncontribs-text' => 'Renomene quiste utende',
	'renamewiki_user-desc' => "Aggiunge 'na [[Special:Renamewiki_user|pàgena speciale]] pe renomena 'n'utende (abbesogne de le deritte ''renamewiki_user'')",
	'renamewiki_userold' => "Nome de l'utende de mò:",
	'renamewiki_usernew' => "Nome de l'utende nuève:",
	'renamewiki_userreason' => "Mutive d'u cangiamende:",
	'renamewiki_usermove' => "Spuèste utende e pàgene de le 'ngazzaminde (e le sottopàggene) a 'u nome nuève",
	'renamewiki_usersuppress' => "Nò ccrejà ridirezionaminde sus a 'u nome nuève",
	'renamewiki_userreserve' => "Blocche 'u nome utende vicchije da le ause future",
	'renamewiki_userwarnings' => 'Avvise:',
	'renamewiki_userconfirm' => "Sine, cange 'u nome a l'utende",
	'renamewiki_usersubmit' => 'Conferme',
	'renamewiki_usererrordoesnotexist' => 'L\'utende "<nowiki>$1</nowiki>" non g\'esiste.',
	'renamewiki_usererrorexists' => 'L\'utende "<nowiki>$1</nowiki>" esiste ggià.',
	'renamewiki_usererrorinvalid' => '\'U nome utende "<nowiki>$1</nowiki>" non è valide.',
	'renamewiki_user-error-request' => "Stave 'nu probbleme cu 'a ricezione d'a richieste.<br />
Pe piacere tuèrne rrete e pruève 'n'otra vote.",
	'renamewiki_user-error-same-wiki_user' => "Tu non ge puè renomenà 'n'utende cu 'u stesse nome d'apprime.",
	'renamewiki_usersuccess' => 'L\'utende "<nowiki>$1</nowiki>" ha cangiate \'u nome jndr\'à "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => "'A pàgene $1 già esiste e non ge se pò automaticamende sovrascrivere.",
	'renamewiki_user-page-moved' => "'A pàgene $1 ha state spustate sus a $2.",
	'renamewiki_user-page-unmoved' => "'A pàgene $1 non ge pò essere spustate sus a $2.",
	'renamewiki_userlogpage' => 'Archivije de le renomenaminde de le utinde',
	'renamewiki_userlogpagetext' => "Quiste jè l'archivije de le cangiaminde de le nome de l'utinde.",
	'renamewiki_userlogentry' => 'renomenate da $1 a "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 cangiamende|$1 cangiaminde}}. Mutive: $2',
	'renamewiki_user-move-log' => 'Pàgena spustate automaticamende quanne è renomenate l\'utende "[[wiki_user:$1|$1]]" jndr\'à "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => "Rennomene l'utinde",
	'renamewiki_user-renamed-notice' => "Stu utende ha state renomenate.
L'archivije de le renomenaziune 'u iacchie aqquà sotte cumme referimende.",
);

/** Russian (русский)
 * @author Ahonc
 * @author DR
 * @author EugeneZelenko
 * @author Innv
 * @author KPu3uC B Poccuu
 * @author Kaganer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'renamewiki_user' => 'Переименовать участника',
	'renamewiki_user-linkoncontribs' => 'переименовать участника',
	'renamewiki_user-linkoncontribs-text' => 'Переименовать этого участника',
	'renamewiki_user-desc' => 'Добавляет [[Special:Renamewiki_user|возможность]] переименования пользователей (требуется право <code>renamewiki_user</code>)',
	'renamewiki_userold' => 'Имя в настоящий момент:',
	'renamewiki_usernew' => 'Новое имя:',
	'renamewiki_userreason' => 'Причина переименования:',
	'renamewiki_usermove' => 'Переименовать также страницу участника, личное обсуждение и их подстраницы',
	'renamewiki_usersuppress' => 'Не создавать перенаправлений на новое имя',
	'renamewiki_userreserve' => 'Зарезервировать старое имя участника для использования в будущем',
	'renamewiki_userwarnings' => 'Предупреждения:',
	'renamewiki_userconfirm' => 'Да, переименовать участника',
	'renamewiki_usersubmit' => 'Выполнить',
	'renamewiki_user-submit-blocklog' => 'Показать журнал блокировок участника',
	'renamewiki_usererrordoesnotexist' => 'Участник с именем «<nowiki>$1</nowiki>» не зарегистрирован.',
	'renamewiki_usererrorexists' => 'Участник с именем «<nowiki>$1</nowiki>» уже зарегистрирован.',
	'renamewiki_usererrorinvalid' => 'Недопустимое имя участника «<nowiki>$1</nowiki>»',
	'renamewiki_user-error-request' => 'Возникли затруднения с получением запроса. Пожалуйста, вернитесь назад и повторите ещё раз.',
	'renamewiki_user-error-same-wiki_user' => 'Вы не можете переименовать участника в тоже имя, что и было раньше.',
	'renamewiki_usersuccess' => 'Участник «<nowiki>$1</nowiki>» был переименован в «<nowiki>$2</nowiki>».',
	'renamewiki_user-page-exists' => 'Страница $1 уже существует и не может быть перезаписана автоматически.',
	'renamewiki_user-page-moved' => 'Страница $1 была переименована в $2.',
	'renamewiki_user-page-unmoved' => 'Страница $1 не может быть переименована в $2.',
	'renamewiki_userlogpage' => 'Журнал переименований участников',
	'renamewiki_userlogpagetext' => 'Это журнал произведённых переименований зарегистрированных участников.',
	'renamewiki_userlogentry' => 'переименовал «$1» в «$2»',
	'renamewiki_user-log' => '$1 {{PLURAL:$1|правка|правки|правок}}. Причина: $2',
	'renamewiki_user-move-log' => 'Автоматически в связи с переименованием учётной записи «[[wiki_user:$1|$1]]» в «[[wiki_user:$2|$2]]»',
	'action-renamewiki_user' => 'переименование участников',
	'right-renamewiki_user' => 'переименование участников',
	'renamewiki_user-renamed-notice' => 'Этот участник был переименован.
Ниже для справки приведён журнал переименований.',
);

/** Rusyn (русиньскый)
 * @author Gazeb
 */
$messages['rue'] = array(
	'renamewiki_user' => 'Переменоватихоснователя',
	'renamewiki_user-linkoncontribs' => 'переменовати хоснователя',
	'renamewiki_user-linkoncontribs-text' => 'Переменовати того хоснователя',
	'renamewiki_user-desc' => 'Придасть [[Special:Renamewiki_user|шпеціалну сторінку]] про переменованя хоснователя (треба права "renamewiki_user")',
	'renamewiki_userold' => 'Актуалне мено:',
	'renamewiki_usernew' => 'Нове мено:',
	'renamewiki_userreason' => 'Причіна переменованя:',
	'renamewiki_usermove' => 'Переменовати тыж сторінкы хоснователя, сторінкы діскузії і їх підсторінкы',
	'renamewiki_usersuppress' => 'Не створюйте напрямлїня на нову назву',
	'renamewiki_userreserve' => 'Блоковати нову реґістрацію старого мена хоснователя',
	'renamewiki_userwarnings' => 'Варованя:',
	'renamewiki_userconfirm' => 'Гей, переменовати хоснователя',
	'renamewiki_usersubmit' => 'Выконати',
	'renamewiki_user-submit-blocklog' => 'Вказати книгу заблокованя того хоснователя',
	'renamewiki_usererrordoesnotexist' => 'Хоснователь з іменом „<nowiki>$1</nowiki>“ не єствує',
	'renamewiki_usererrorexists' => 'Хоснователь з іменом „<nowiki>$1</nowiki>“ уж єствує',
	'renamewiki_usererrorinvalid' => 'Хоснователське імя „<nowiki>$1</nowiki>“ ся не дасть хосновати',
	'renamewiki_user-error-request' => 'Почас приїманя пожадавкы дішло ку хыбі. Вернийте ся і спробуйте то знову.',
	'renamewiki_user-error-same-wiki_user' => 'Нове імя хоснователя є тото саме як дотеперїшнє.',
	'renamewiki_usersuccess' => 'Хоснователь „<nowiki>$1</nowiki>“ быв успішно переменованый на „<nowiki>$2</nowiki>“',
	'renamewiki_user-page-exists' => 'Сторінка $1 уж екзістує і не може быти автоматічно переписана.',
	'renamewiki_user-page-moved' => 'Сторінка $1 была переменована на $2.',
	'renamewiki_user-page-unmoved' => 'Сторінка $1 не може быти переменована на $2.',
	'renamewiki_userlogpage' => 'Лоґ переменовань хоснователїв',
	'renamewiki_userlogpagetext' => 'Тото є протокол  переменовань хоснователїв',
	'renamewiki_userlogentry' => 'переменовав $1 на „$2“',
	'renamewiki_user-log' => '{{PLURAL:$1|1 едітованя|$1 едітовань|$1 едітовань}}. Причіна: $2',
	'renamewiki_user-move-log' => 'Автоматічне переменованя сторінкы почас переменованя хоснователя „[[wiki_user:$1|$1]]“ на „[[wiki_user:$2|$2]]“',
	'action-renamewiki_user' => 'переменовати хоснователїв',
	'right-renamewiki_user' => 'Переменованя хоснователїв',
	'renamewiki_user-renamed-notice' => 'Тот хоснователь быв переменованый.
Про перегляд є ниже указаный выпис з лоґу переменовань хоснователїв.',
);

/** Sanskrit (संस्कृतम्)
 * @author Ansumang
 * @author Shubha
 */
$messages['sa'] = array(
	'renamewiki_user' => 'यॊजकस्य पुनर्नामकरणं क्रियताम्',
	'renamewiki_user-linkoncontribs' => 'यॊजकनाम परिवर्त्यताम्',
	'renamewiki_user-linkoncontribs-text' => 'अस्य योजकस्य नाम परिवर्त्यताम्',
	'renamewiki_user-desc' => "योजकस्य पुनर्नामकरणं कर्तुं (''योजकपुनर्नाम''अधिकारः अपेक्षितः)  [[Special:Renamewiki_user|विशेषपृष्ठम्]] योजयति",
	'renamewiki_userold' => 'प्रस्तुतयोजकनाम :',
	'renamewiki_usernew' => 'नूतनयोजकनाम :',
	'renamewiki_userreason' => 'नामपरिवर्तनस्य कारणम् :',
	'renamewiki_usermove' => 'योजकः सम्भाषणपृष्ठं (तेषाम् उपपृष्ठानि) च नूतननाम प्रति चाल्यताम्',
	'renamewiki_usersuppress' => 'नूतननाम्नः पुनर्निदेशनं न सृज्यताम्',
	'renamewiki_userreserve' => 'भविष्ये उपयोगाय पुरातनं योजकनाम अवरुद्ध्यताम्',
	'renamewiki_userwarnings' => 'चेतावनी:',
	'renamewiki_userconfirm' => 'आम्, योजकस्य पुनर्नाम दीयताम्',
	'renamewiki_usersubmit' => 'उपस्थाप्यताम्',
	'renamewiki_user-submit-blocklog' => 'योजकस्य अवरोधवृत्तं दर्श्यताम्',
	'renamewiki_usererrordoesnotexist' => 'सदस्यः "<nowiki>$1</nowiki>" न विद्यते ।',
	'renamewiki_usererrorexists' => 'योजकः  "<nowiki>$1</nowiki>" पूर्वमेव विद्यते ।',
	'renamewiki_usererrorinvalid' => 'योजकनाम "<nowiki>$1</nowiki>" दोषयुक्तं विद्यते ।',
	'renamewiki_user-error-request' => 'निवेदनस्य प्राप्तौ कश्चन क्लेशः आसीत् ।
कृपया प्रतिगत्य प्रयतताम् ।',
	'renamewiki_user-error-same-wiki_user' => 'योजकस्य पूर्वनाम दत्त्वा पुनः नामकरणं न शक्यते ।',
	'renamewiki_usersuccess' => '"<nowiki>$1</nowiki>" इत्यस्य योजकनाम "<nowiki>$2</nowiki>" कृतमस्ति ।',
	'renamewiki_user-page-exists' => '$1 इत्येतत् पुटं पूर्वमेव विद्यते । तदुपरि लेखनम् अशक्यम् ।',
	'renamewiki_user-page-moved' => '$1 पृष्ठं $2 प्रति चालितम् अस्ति ।',
	'renamewiki_user-page-unmoved' => '$1 पृष्ठं $2 प्रति चालनम् अशक्यम् ।',
	'renamewiki_userlogpage' => 'परिवर्तितयोजकनाम्नां वृत्तम्',
	'renamewiki_userlogpagetext' => 'इदं योजकनाम्नां परिवर्तनवृत्तम् ।',
	'renamewiki_userlogentry' => '$1  "$2" प्रति परिवर्तितमस्ति ।',
	'renamewiki_user-log' => '{{PLURAL:$1|1 परिवर्तनम्|$1 परिवर्तनानि}}. कारणम्: $2',
	'renamewiki_user-move-log' => '"[[wiki_user:$1|$1]]" तः "[[wiki_user:$2|$2]]" प्रति योजकनाम्नः परिवर्तनावसरे एव योजकपृष्ठं स्वयं चालितम् ।',
	'action-renamewiki_user' => 'यॊजकस्य पुनर्नामकरणं क्रियताम्',
	'right-renamewiki_user' => 'यॊजकस्य पुनर्नामकरणं क्रियताम्',
	'renamewiki_user-renamed-notice' => 'अस्य योजकस्य पुनर्नामकरणं कृतमस्ति ।
परिवर्तनवृत्तम् अधः आधाररूपेण दत्तमस्ति ।',
);

/** Sakha (саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'renamewiki_user' => 'Кыттааччы аатын уларыт',
	'renamewiki_user-linkoncontribs' => 'кыттааччы аатын уларытыы',
	'renamewiki_user-linkoncontribs-text' => 'Бу кыттааччы аатын уларыт',
	'renamewiki_user-desc' => "Кыттааччы аатын уларытыы (''renamewiki_user'' бырааба наада)",
	'renamewiki_userold' => 'Билиҥҥи аата:',
	'renamewiki_usernew' => 'Саҥа аата:',
	'renamewiki_userreason' => 'Аатын уларыппыт төрүөтэ:',
	'renamewiki_usermove' => 'Кыттааччы аатын кытта кэпсэтэр сирин, уонна атын сирэйдэрин ааттарын уларыт',
	'renamewiki_usersuppress' => 'Саҥа аакка утаарыылары оҥорума',
	'renamewiki_userreserve' => 'Кыттааччы урукку аатын кэлин туттарга анаан хааллар',
	'renamewiki_userwarnings' => 'Сэрэтиилэр:',
	'renamewiki_userconfirm' => 'Сөп, аатын уларыт',
	'renamewiki_usersubmit' => 'Толор',
	'renamewiki_usererrordoesnotexist' => 'Маннык ааттаах кыттааччы «<nowiki>$1</nowiki>» бэлиэтэммэтэх.',
	'renamewiki_usererrorexists' => 'Маннык ааттаах кыттааччы "<nowiki>$1</nowiki>" номнуо баар.',
	'renamewiki_usererrorinvalid' => 'Маннык аат "<nowiki>$1</nowiki>" көҥуллэммэт.',
	'renamewiki_user-error-request' => 'Запрос тутуута моһуоктанна. Бука диэн төнүн уонна хатылаа.',
	'renamewiki_user-error-same-wiki_user' => 'Кыттааччы аатын урукку аатыгар уларытар табыллыбат.',
	'renamewiki_usersuccess' => '"<nowiki>$1</nowiki>" кыттааччы мантан ыла "<nowiki>$2</nowiki>" диэн ааттанна.',
	'renamewiki_user-page-exists' => '$1 сирэй номнуо баар онон аптамаатынан хат суруллар кыаҕа суох.',
	'renamewiki_user-page-moved' => '$1 сирэй маннык ааттаммыт $2.',
	'renamewiki_user-page-unmoved' => '$1 сирэй маннык $2 ааттанар кыаҕа суох.',
	'renamewiki_userlogpage' => 'Кыттааччылар ааттарын уларытыыларын сурунаала',
	'renamewiki_userlogpagetext' => 'Бу бэлиэтэммит кыттааччылар ааттарын уларытыыларын сурунаала',
	'renamewiki_userlogentry' => '$1 аатын манныкка уларытта "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|Биирдэ|$1 төгүл}} уларыйбыт. Төрүөтэ: $2',
	'renamewiki_user-move-log' => '«[[wiki_user:$1|$1]]» аата «[[wiki_user:$2|$2]]» буолбутунан аптамаатынан',
	'right-renamewiki_user' => 'Кыттааччылар ааттарын уларытыы',
	'renamewiki_user-renamed-notice' => 'Бу кыттааччы аата уларыйбыт.
Аллара аат уларыйыытын сурунаала көстөр.',
);

/** Sardinian (sardu)
 * @author Andria
 * @author Marzedu
 */
$messages['sc'] = array(
	'renamewiki_usernew' => 'Nou nùmene usuàriu:',
);

/** Sicilian (sicilianu)
 * @author Gmelfi
 * @author Santu
 */
$messages['scn'] = array(
	'renamewiki_user' => 'Rinòmina utenti',
	'renamewiki_user-linkoncontribs' => "Rinòmina l'utenti",
	'renamewiki_user-desc' => "Funzioni pi rinuminari n'utenti (addumanna li diritti di ''renamewiki_user'')",
	'renamewiki_userold' => 'Nomu utenti dô prisenti:',
	'renamewiki_usernew' => 'Novu nomu utenti:',
	'renamewiki_userreason' => 'Mutivu dû caciu di nomu',
	'renamewiki_usermove' => 'Rinòmina macari la pàggina utenti, la pàggina di discussioni e li suttapàggini',
	'renamewiki_userreserve' => 'Sarva lu vecchiu utenti pi futuri usi',
	'renamewiki_userwarnings' => 'Avvisi:',
	'renamewiki_userconfirm' => "Si, rinòmina st'utenti",
	'renamewiki_usersubmit' => 'Manna',
	'renamewiki_usererrordoesnotexist' => 'L\'utenti "<nowiki>$1</nowiki>" nun esisti',
	'renamewiki_usererrorexists' => 'L\'utenti "<nowiki>$1</nowiki>" c\'è già',
	'renamewiki_usererrorinvalid' => 'Lu nomu utenti "<nowiki>$1</nowiki>" nun è vàlidu',
	'renamewiki_user-error-request' => "Si virificau nu prubbrema nnô ricivimentu dâ dumanna. Turnari arredi e pruvari n'àutra vota.",
	'renamewiki_user-error-same-wiki_user' => "Nun si pò ri-numinari n'utenti cô stissu nomu c'avìa già.",
	'renamewiki_usersuccess' => 'L\'utenti "<nowiki>$1</nowiki>" vinni ri-numinatu \'n "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => "La pàggina $1 c'è già; mpussìbbili suprascrivìrila autumaticamenti.",
	'renamewiki_user-page-moved' => 'La pàggina $1 vinni spustata a $2.',
	'renamewiki_user-page-unmoved' => 'Mpussìbbili mòviri la pàggina $1 a $2.',
	'renamewiki_userlogpage' => 'Utenti ri-numinati',
	'renamewiki_userlogpagetext' => "Di sècutu sunnu elencati li ri-numinazzioni di l'utenti.",
	'renamewiki_userlogentry' => 'hà ri-numinatu $1 \'n "$2"',
	'renamewiki_user-log' => 'Ca havi {{PLURAL:$1|nu cuntribbutu|$1 cuntribbuti}}. Mutivu: $2',
	'renamewiki_user-move-log' => 'Spustamentu autumàticu dâ pàggina - utenti ri-numinatu di "[[wiki_user:$1|$1]]" a "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => "Ri-nòmina l'utenti",
);

/** Samogitian (žemaitėška)
 * @author Hugo.arg
 */
$messages['sgs'] = array(
	'renamewiki_userold' => 'Esams nauduotuojė vards:',
	'renamewiki_usernew' => 'Naus nauduotuojė vards:',
	'renamewiki_usersuccess' => 'Nauduotuos "<nowiki>$1</nowiki>" bova parvadėnts i "<nowiki>$2</nowiki>".',
);

/** Serbo-Croatian (srpskohrvatski / српскохрватски)
 * @author OC Ripper
 */
$messages['sh'] = array(
	'renamewiki_usersubmit' => 'Unesi',
);

/** Sinhala (සිංහල)
 * @author Budhajeewa
 * @author තඹරු විජේසේකර
 * @author නන්දිමිතුරු
 * @author පසිඳු කාවින්ද
 * @author ශ්වෙත
 */
$messages['si'] = array(
	'renamewiki_user' => 'පරිශීලකයා යළි-නම්කරන්න',
	'renamewiki_user-linkoncontribs' => 'පරිශීලකයා යළි-නම්කරන්න',
	'renamewiki_user-linkoncontribs-text' => 'මෙම පරිශීලකයා ප්‍රති-නම් කරන්න',
	'renamewiki_user-desc' => "පරිශීලකයෙක් යළි-නම්කරනු වස් [[Special:Renamewiki_user|විශේෂ පිටුවක්]] එක් කරන්න (''renamewiki_user'' අයිතිය අවශ්‍යයි)",
	'renamewiki_userold' => 'වත්මන් පරිශීලක නාමය:',
	'renamewiki_usernew' => 'නව පරිශීලක නාමය:',
	'renamewiki_userreason' => 'යළි-නම්කිරීමට හේතුව:',
	'renamewiki_usermove' => 'පරිශීලක හා සාකච්ඡා පිටු   (හා  ඒවායේ උපපිටු) නව නම වෙතට ගෙන යන්න',
	'renamewiki_usersuppress' => 'යළි යොමුවන් නම නාමයේ සැකසීමෙන් වළකින්න.',
	'renamewiki_userreserve' => 'පැරණි පරිශීලක නම අනාගත භාවිතයෙන් වාරණය කරන්න',
	'renamewiki_userwarnings' => 'අවවාදයන්:',
	'renamewiki_userconfirm' => 'ඔව්, පරිශීලකයා යළි-නම්කරන්න',
	'renamewiki_usersubmit' => 'යොමන්න',
	'renamewiki_user-submit-blocklog' => 'පරිශීලක සඳහා වාරණ ලඝු සටහන පෙන්වන්න',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" පරිශීලකයා නොපවතී.',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" පරිශීලකයා දැනටමත් පවතියි.',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" පරිශීලක නාමය අනීතිකයි.',
	'renamewiki_user-error-request' => 'ඉල්ලීම ලැබීමේ දෝෂයක් හට ගැනිනි.
කරුණාකර ආපසු ගොස් නැවත උත්සාහ කරන්න.',
	'renamewiki_user-error-same-wiki_user' => 'ඔබට පරිශීලකයෙක් පෙර තිබූ නමටම ප්‍රතිනම්කළ නොහැක.',
	'renamewiki_usersuccess' => '"<nowiki>$1</nowiki>" පරිශීලකයා "<nowiki>$2</nowiki>" වෙත ප්‍රතිනම් කෙරිනි.',
	'renamewiki_user-page-exists' => '$1 පිටුව දැනටමත් පවතින අතර, එය ස්වයංක්‍රීයව අධිලිවීමකට භාජනය කල නොහැක.',
	'renamewiki_user-page-moved' => ' $1 පිටුව $2 වෙත ගෙනයන ලදි.',
	'renamewiki_user-page-unmoved' => ' $1 පිටුව  $2 වෙත ගෙනයා නොහැක.',
	'renamewiki_userlogpage' => 'පරිශීලක ප්‍රතිනම්කෙරුම් ලොගය',
	'renamewiki_userlogpagetext' => 'මෙය පරිශීලක නාම වෙනස්වීම් පිළිබඳ ලඝු-සටහනකි.',
	'renamewiki_userlogentry' => '$1, "$2" ලෙස ප්‍රතිනම් කෙරිනි',
	'renamewiki_user-log' => '{{PLURAL:$1|එක් සංස්කරණයක්|සංස්කරණ $1 ක්}}. හේතුව: $2',
	'renamewiki_user-move-log' => 'පරිශීලක "[[wiki_user:$1|$1]]", "[[wiki_user:$2|$2]]" වෙත ප්‍රතිනම්කරන අතරතුර පිටුව ස්‍වයංක්‍රීයව ගෙනයන ලදී',
	'action-renamewiki_user' => 'පරිශීලකයන් ප්‍රතිනම් කරන්න',
	'right-renamewiki_user' => 'පරිශීලකයන් ප්‍රතිනම් කරන්න',
	'renamewiki_user-renamed-notice' => 'මෙම පරිශීලකයා ප්‍රතිනම්කර ඇත.
ප්‍රතිනම්කෙරුම් ලඝු-සටහන පහත දක්වා ඇත.',
);

/** Slovak (slovenčina)
 * @author Helix84
 * @author Jkjk
 */
$messages['sk'] = array(
	'renamewiki_user' => 'Premenovať používateľa',
	'renamewiki_user-linkoncontribs' => 'premenovať používateľa',
	'renamewiki_user-linkoncontribs-text' => 'Premenovať tohto používateľa',
	'renamewiki_user-desc' => "Premenovať používateľa (vyžaduje právo ''renamewiki_user'')",
	'renamewiki_userold' => 'Súčasné používateľské meno:',
	'renamewiki_usernew' => 'Nové používateľské meno:',
	'renamewiki_userreason' => 'Dôvod premenovania:',
	'renamewiki_usermove' => 'Presunúť používateľské a diskusné stránky (a ich podstránky) na nový názov',
	'renamewiki_usersuppress' => 'Nevytvárať presmerovania na nový názov',
	'renamewiki_userreserve' => 'Vyhradiť staré používateľské meno (zabrániť ďalšiemu použitiu)',
	'renamewiki_userwarnings' => 'Upozornenia:',
	'renamewiki_userconfirm' => 'Áno, premenovať používateľa',
	'renamewiki_usersubmit' => 'Odoslať',
	'renamewiki_user-submit-blocklog' => 'Zobraziť záznam blokovaní používateľa',
	'renamewiki_usererrordoesnotexist' => 'Používateľ „<nowiki>$1</nowiki>“  neexistuje',
	'renamewiki_usererrorexists' => 'Používateľ „<nowiki>$1</nowiki>“ už existuje',
	'renamewiki_usererrorinvalid' => 'Používateľské meno „<nowiki>$1</nowiki>“ je neplatné',
	'renamewiki_user-error-request' => 'Pri prijímaní vašej požiadavky nastal problém. Prosím, vráťte sa a skúste to znova.',
	'renamewiki_user-error-same-wiki_user' => 'Nemôžete premenovať používateľa na rovnaké meno ako mal predtým.',
	'renamewiki_usersuccess' => 'Používateľ „<nowiki>$1</nowiki>“ bol premenovaný na „<nowiki>$2</nowiki>“',
	'renamewiki_user-page-exists' => 'Stránka $1 už existuje a nie je možné ju automaticky prepísať.',
	'renamewiki_user-page-moved' => 'Stránka $1 bola presunutá na $2.',
	'renamewiki_user-page-unmoved' => 'Stránku $1 nebolo možné presunúť na $2.',
	'renamewiki_userlogpage' => 'Záznam premenovaní používateľov',
	'renamewiki_userlogpagetext' => 'Toto je záznam premenovaní používateľov',
	'renamewiki_userlogentry' => 'premenoval používateľa $1 na „$2”',
	'renamewiki_user-log' => 'mal {{PLURAL:$1|1 úpravu|$1 úpravy|$1 úprav}}. Dôvod: $2',
	'renamewiki_user-move-log' => 'Automaticky presunutá stránka počas premenovania používateľa „[[wiki_user:$1|$1]]“ na „[[wiki_user:$2|$2]]“',
	'action-renamewiki_user' => 'premenovať používateľov',
	'right-renamewiki_user' => 'Premenovávať používateľov',
	'renamewiki_user-renamed-notice' => 'Tento používateľ bol premenovaný.
Dolu nájdete záznam premenovaní.',
);

/** Slovenian (slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'renamewiki_user' => 'Preimenovanje uporabnika',
	'renamewiki_user-linkoncontribs' => 'preimenuj uporabnika',
	'renamewiki_user-linkoncontribs-text' => 'Preimenuj tega uporabnika',
	'renamewiki_user-desc' => "Doda [[Special:Renamewiki_user|posebno stran]] za preimenovanje uporabnika (potrebna je pravica ''renamewiki_user'')",
	'renamewiki_userold' => 'Trenutno uporabniško ime:',
	'renamewiki_usernew' => 'Novo uporabniško ime:',
	'renamewiki_userreason' => 'Razlog preimenovanja:',
	'renamewiki_usermove' => 'Prestavi uporabniške in pogovorne strani (ter njihove podstrani) na novo ime',
	'renamewiki_usersuppress' => 'Ne ustvari preusmeritev na novo ime',
	'renamewiki_userreserve' => 'Blokiraj staro uporabniško ime pred nadaljnjo uporabo',
	'renamewiki_userwarnings' => 'Opozorila:',
	'renamewiki_userconfirm' => 'Da, preimenuj uporabnika',
	'renamewiki_usersubmit' => 'Potrdi',
	'renamewiki_user-submit-blocklog' => 'Pokaži dnevnik blokiranja uporabnika',
	'renamewiki_usererrordoesnotexist' => 'Uporabnik »<nowiki>$1</nowiki>« ne obstaja.',
	'renamewiki_usererrorexists' => 'Uporabnik »<nowiki>$1</nowiki>« že obstaja.',
	'renamewiki_usererrorinvalid' => 'Uporabniško ime »<nowiki>$1</nowiki>« ni veljavno.',
	'renamewiki_user-error-request' => 'Pri prejemanju zahteve je prišlo do težave.
Prosimo, pojdite nazaj in poskusite znova.',
	'renamewiki_user-error-same-wiki_user' => 'Uporabnika ne morete preimenovati v isto stvar kot prej.',
	'renamewiki_usersuccess' => 'Uporabnik »<nowiki>$1</nowiki>« je bil preimenovan v »<nowiki>$2</nowiki>«.',
	'renamewiki_user-page-exists' => 'Stran $1 že obstaja in je ni mogoče samodejno prepisati.',
	'renamewiki_user-page-moved' => 'Stran $1 je bila prestavljena na $2.',
	'renamewiki_user-page-unmoved' => 'Strani $1 ni mogoče prestaviti na $2.',
	'renamewiki_userlogpage' => 'Dnevnik preimenovanj uporabnikov',
	'renamewiki_userlogpagetext' => 'Prikazan je dnevnik sprememb uporabniških imen.',
	'renamewiki_userlogentry' => '- preimenovanje $1 v »$2«',
	'renamewiki_user-log' => '$1 {{PLURAL:$1|urejanje|urejanji|urejanja|urejanj}}. Razlog: $2',
	'renamewiki_user-move-log' => 'Samodejno prestavljanje strani pri preimenovanju uporabnika »[[wiki_user:$1|$1]]« v »[[wiki_user:$2|$2]]«',
	'action-renamewiki_user' => 'preimenovanje uporabnikov',
	'right-renamewiki_user' => 'Preimenovanje uporabnikov',
	'renamewiki_user-renamed-notice' => 'Ta uporabnik je bil preimenovan.
Dnevnik preimenovanja je naveden spodaj.',
);

/** Lower Silesian (Schläsch)
 * @author Schläsinger
 */
$messages['sli'] = array(
	'renamewiki_userold' => 'Bisheriger Benutzernoame:',
	'renamewiki_usernew' => 'Neuer Benutzernoame:',
	'renamewiki_userreason' => 'Grund:',
);

/** Albanian (shqip)
 * @author Dori
 * @author FatosMorina
 * @author Mikullovci11
 * @author Olsi
 */
$messages['sq'] = array(
	'renamewiki_user' => 'Riemëroje përdoruesin',
	'renamewiki_user-linkoncontribs' => 'Riemëroje përdoruesin',
	'renamewiki_user-linkoncontribs-text' => 'Riemëroje këtë përdoruesin',
	'renamewiki_user-desc' => "Shton një [[Special:Renamewiki_user|faqe speciale]] për të riemëruar një përdorues (duhet e drejta ''renamewiki_user'')",
	'renamewiki_userold' => 'Emri i tanishëm',
	'renamewiki_usernew' => 'Emri i ri',
	'renamewiki_userreason' => 'Arsyeja për riemërim:',
	'renamewiki_usermove' => 'Zhvendos faqet e përdoruesit dhe të diskutimit (dhe nën-faqet e tyre) tek emri i ri',
	'renamewiki_usersuppress' => 'Mos krijoni përcjellime tek emri i ri',
	'renamewiki_userreserve' => 'Bllokoni emrin e vjetër të përdoruesit të përdorim në të ardhmen',
	'renamewiki_userwarnings' => 'Paralajmërimet:',
	'renamewiki_userconfirm' => 'Po, ndërrojë emrin e përdoruesit',
	'renamewiki_usersubmit' => 'Ndryshoje',
	'renamewiki_user-submit-blocklog' => 'Shfaq shënimet e bllokimit për përdoruesin',
	'renamewiki_usererrordoesnotexist' => 'Përdoruesi me emër "<nowiki>$1</nowiki>" nuk ekziston',
	'renamewiki_usererrorexists' => 'Përdoruesi me emër "<nowiki>$1</nowiki>" ekziston',
	'renamewiki_usererrorinvalid' => 'Emri "<nowiki>$1</nowiki>" nuk është i lejuar',
	'renamewiki_user-error-request' => 'Kishte një problem me marrjen e kërkesës.
Ju lutemi kthehuni prapa dhe provoni përsëri.',
	'renamewiki_user-error-same-wiki_user' => 'Ju nuk mund të riemëroni një përdorues tek e njëjta gjë si më parë.',
	'renamewiki_usersuccess' => 'Përdoruesi "<nowiki>$1</nowiki>" u riemërua në "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'Faqja $1 ekziston dhe nuk mund të mbivendoset automatikisht.',
	'renamewiki_user-page-moved' => 'Faqja $1 është zhvendosur tek $2.',
	'renamewiki_user-page-unmoved' => "Faqja $1 s'mund të zhvendosej tek $2.",
	'renamewiki_userlogpage' => 'Regjistri i emër-ndryshimeve',
	'renamewiki_userlogpagetext' => 'Ky është një regjistër i ndryshimeve së emrave të përdoruesve',
	'renamewiki_userlogentry' => 'riemëruar $1 tek "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 redaktim|$1 redaktime}}. Arsyeja: $2',
	'renamewiki_user-move-log' => 'Lëvizi faqen automatikisht kur riemëroi përdoruesin "[[wiki_user:$1|$1]]" në "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'riemëro përdoruesit',
	'right-renamewiki_user' => 'Riemëroni përdorueset',
	'renamewiki_user-renamed-notice' => 'Ky përdorues është riemëruar.
Regjistri i riemërimit është poshtë për referencë.',
);

/** Serbian (Cyrillic script) (српски (ћирилица)‎)
 * @author FriedrickMILBarbarossa
 * @author Millosh
 * @author Rancher
 * @author Sasa Stefanovic
 * @author Жељко Тодоровић
 * @author Михајло Анђелковић
 */
$messages['sr-ec'] = array(
	'renamewiki_user' => 'Преименуј корисника',
	'renamewiki_user-linkoncontribs' => 'преименуј корисника',
	'renamewiki_user-linkoncontribs-text' => 'Преименуј овог корисника',
	'renamewiki_user-desc' => "Додаје [[Special:Renamewiki_user|посебну страницу]] за преименовање корисника (потребно право ''renamewiki_user'')",
	'renamewiki_userold' => 'Тренутно корисничко име:',
	'renamewiki_usernew' => 'Ново корисничко име:',
	'renamewiki_userreason' => 'Разлог:',
	'renamewiki_usermove' => 'Премести корисничку страницу и страницу за разговор (и њихове подстранице) на нови назив',
	'renamewiki_usersuppress' => 'Не правите преусмерења на нови назив',
	'renamewiki_userreserve' => 'Блокирај старо корисничко име за даљу употребу',
	'renamewiki_userwarnings' => 'Упозорења:',
	'renamewiki_userconfirm' => 'Да, преименуј корисника',
	'renamewiki_usersubmit' => 'Прихвати',
	'renamewiki_user-submit-blocklog' => 'Дневник блокирања за корисника',
	'renamewiki_usererrordoesnotexist' => 'Корисник „<nowiki>$1</nowiki>“ не постоји.',
	'renamewiki_usererrorexists' => 'Корисник „<nowiki>$1</nowiki>“ већ постоји.',
	'renamewiki_usererrorinvalid' => 'Погрешно корисничко име: "<nowiki>$1</nowiki>"',
	'renamewiki_user-error-request' => 'Дошло је до проблема при примању захтева.
Вратите се назад и покушајте поново.',
	'renamewiki_user-error-same-wiki_user' => 'Не можете преименовати корисника у исто име.',
	'renamewiki_usersuccess' => 'Корисник "<nowiki>$1</nowiki>" је преименован на "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'Страница $1 већ постоји и не може се заменити.',
	'renamewiki_user-page-moved' => 'Страница $1 је премештена у $2.',
	'renamewiki_user-page-unmoved' => 'Страница $1 не може да се премести на $2.',
	'renamewiki_userlogpage' => 'Дневник преименовања корисника',
	'renamewiki_userlogpagetext' => 'Ово је историја измена корисничких имена.',
	'renamewiki_userlogentry' => '{{GENDER:|је преименовао|је преименовала|је преименовао}} $1 у „$2“',
	'renamewiki_user-log' => '{{PLURAL:$1|1 измена|$1 измене|$1 измена}}.
Разлог: $2',
	'renamewiki_user-move-log' => 'Премештене странице приликом преименовања корисника: „[[wiki_user:$1|$1]]“ у „[[wiki_user:$2|$2]]“.',
	'action-renamewiki_user' => 'преименовање корисника',
	'right-renamewiki_user' => 'преименовање корисничких имена',
	'renamewiki_user-renamed-notice' => 'Овом кориснику је промењено име.
Историја промена имена је приложена испод, као информација.',
);

/** Serbian (Latin script) (srpski (latinica)‎)
 * @author FriedrickMILBarbarossa
 * @author Liangent
 * @author Michaello
 * @author Жељко Тодоровић
 */
$messages['sr-el'] = array(
	'renamewiki_user' => 'Preimenuj korisnika',
	'renamewiki_user-linkoncontribs' => 'preimenuj korisnika',
	'renamewiki_user-linkoncontribs-text' => 'Preimenuj ovog korisnika',
	'renamewiki_user-desc' => "Dodaje [[Special:Renamewiki_user|posebnu stranicu]] za preimenovanje korisnika (potrebno pravo ''renamewiki_user'').",
	'renamewiki_userold' => 'Trenutno korisničko ime:',
	'renamewiki_usernew' => 'Novo korisničko ime:',
	'renamewiki_userreason' => 'Razlog preimenovanja:',
	'renamewiki_usermove' => 'Premesti korisničku stranicu i stranicu za razgovor (i njihove podstranice) na novo ime',
	'renamewiki_usersuppress' => 'Ne pravite preusmerenja na novi naziv',
	'renamewiki_userreserve' => 'Blokiraj staro korisničko ime za dalju upotrebu',
	'renamewiki_userwarnings' => 'Upozorenja:',
	'renamewiki_userconfirm' => 'Da, preimenuj korisničko ime.',
	'renamewiki_usersubmit' => 'Prihvati',
	'renamewiki_user-submit-blocklog' => 'Dnevnik blokiranja za korisnika',
	'renamewiki_usererrordoesnotexist' => 'Korisnik "<nowiki>$1</nowiki>" ne postoji',
	'renamewiki_usererrorexists' => 'Korisnik "<nowiki>$1</nowiki>" već postoji',
	'renamewiki_usererrorinvalid' => 'Pogrešno korisničko ime: "<nowiki>$1</nowiki>"',
	'renamewiki_user-error-request' => 'Javio se problem prilikom prihvatanja zahteva. Idi nazad i pokušaj ponovo.',
	'renamewiki_user-error-same-wiki_user' => 'Ne možeš preimenovati korisničko ime u isto kao i prethodno.',
	'renamewiki_usersuccess' => 'Korisnik "<nowiki>$1</nowiki>" je preimenovan na "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'Stranica $1 već postoji i ne može biti automatski presnimljena.',
	'renamewiki_user-page-moved' => 'Stranica $1 je premeštena na $2.',
	'renamewiki_user-page-unmoved' => 'Stranica $1 ne može biti premeštena na $2.',
	'renamewiki_userlogpage' => 'Dnevnik preimenovanja korisnika',
	'renamewiki_userlogpagetext' => 'Ovo je istorija izmena korisničkih imena.',
	'renamewiki_userlogentry' => 'je preimenovao $1 u „$2“',
	'renamewiki_user-log' => '{{PLURAL:$1|1 izmena|$1 izmene|$1 izmena}}. Razlog: $2',
	'renamewiki_user-move-log' => 'Automatski pomerene stranice prilikom preimenovanja korisničkog imena: „[[wiki_user:$1|$1]]“ u „[[wiki_user:$2|$2]]“.',
	'action-renamewiki_user' => 'preimenovanje korisnika',
	'right-renamewiki_user' => 'preimenovanje korisničkih imena',
	'renamewiki_user-renamed-notice' => 'Ovom korisniku je promenjeno ime.
Istorija promena imena je priložena ispod, kao informacija.',
);

/** Seeltersk (Seeltersk)
 * @author Maartenvdbent
 * @author Pyt
 */
$messages['stq'] = array(
	'renamewiki_user' => 'Benutsernoome annerje',
	'renamewiki_user-desc' => "Föiget ne [[Special:Renamewiki_user|Spezioalsiede]] bietou tou Uumbenaamenge fon n Benutser (fräiget dät ''renamewiki_user''-Gjucht)",
	'renamewiki_userold' => 'Benutsernoomer bithäär:',
	'renamewiki_usernew' => 'Näie Benutsernoome:',
	'renamewiki_userreason' => 'Gruund foar Uumenaame:',
	'renamewiki_usermove' => 'Ferskuuwe Benutser-/Diskussionssiede inkl. Unnersieden ap dän näie Benutsernoome',
	'renamewiki_userreserve' => 'Blokkierje dän oolde Benutsernoome foar ne näie Registrierenge',
	'renamewiki_userwarnings' => 'Woarskauengen:',
	'renamewiki_userconfirm' => 'Jee, Benutser uumbenaame',
	'renamewiki_usersubmit' => 'Uumbenaame',
	'renamewiki_usererrordoesnotexist' => 'Die Benutsernoome "<nowiki>$1</nowiki>" bestoant nit',
	'renamewiki_usererrorexists' => 'Die Benutsernoome "<nowiki>$1</nowiki>" bestoant al',
	'renamewiki_usererrorinvalid' => 'Die Benutsernoome "<nowiki>$1</nowiki>" is uungultich',
	'renamewiki_user-error-request' => 'Dät roat n Problem bie dän Ämpfang fon ju Anfroage. Fersäik jädden nochmoal.',
	'renamewiki_user-error-same-wiki_user' => 'Oolde un näie Benutsernoome sunt identisk.',
	'renamewiki_usersuccess' => 'Die Benutser "<nowiki>$1</nowiki>" wuude mäd Ärfoulch uumenaamd in "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'Ju Siede $1 bestoant al un kon nit automatisk uurskrieuwen wäide.',
	'renamewiki_user-page-moved' => 'Ju Siede $1 wuude ätter $2 ferskäuwen.',
	'renamewiki_user-page-unmoved' => 'Ju Siede $1 kuude nit ätter $2 ferskäuwen wäide.',
	'renamewiki_userlogpage' => 'Benutsernoomenannerengs-Logbouk',
	'renamewiki_userlogpagetext' => 'In dit Logbouk wäide do Annerengen fon Benutsernoomen protokollierd.',
	'renamewiki_userlogentry' => 'häd "$1" in "$2" uumenaamd',
	'renamewiki_user-log' => '{{PLURAL:$1|1 Beoarbaidenge|$1 Beoarbaidengen}}. Gruund: $2',
	'renamewiki_user-move-log' => 'truch ju Uumbenaamenge fon „[[wiki_user:$1|$1]]“ ätter „[[wiki_user:$2|$2]]“ automatisk ferskäuwene Siede.',
	'right-renamewiki_user' => 'Benutser uumenaame',
);

/** Sundanese (Basa Sunda)
 * @author Irwangatot
 * @author Kandar
 */
$messages['su'] = array(
	'renamewiki_user' => 'Ganti ngaran pamaké',
	'renamewiki_user-desc' => "Ganti ngaran pamaké (perlu kawenangan ''renamewiki_user'')",
	'renamewiki_userold' => 'Ngaran pamaké ayeuna:',
	'renamewiki_usernew' => 'Ngaran pamaké anyar:',
	'renamewiki_userreason' => 'Alesan ganti ngaran:',
	'renamewiki_usermove' => 'Pindahkeun kaca pamaké jeung obrolanna (jeung sub-kacanna) ka ngaran anyar',
	'renamewiki_usersubmit' => 'Kirim',
	'renamewiki_usererrordoesnotexist' => 'Euweuh pamaké nu ngaranna "<nowiki>$1</nowiki>"',
	'renamewiki_usererrorexists' => 'Pamaké "<nowiki>$1</nowiki>" geus aya',
	'renamewiki_usererrorinvalid' => 'Ngaran pamaké "<nowiki>$1</nowiki>" teu sah',
	'renamewiki_user-error-request' => 'Aya gangguan nalika nampa paménta. Coba balik deui, terus cobaan deui.',
	'renamewiki_user-error-same-wiki_user' => 'Anjeun teu bisa ngaganti ngaran pamaké ka ngaran nu éta-éta kénéh.',
	'renamewiki_usersuccess' => 'Pamaké "<nowiki>$1</nowiki>" geus diganti ngaranna jadi "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'Kaca $1 geus aya sarta teu bisa ditimpah kitu baé.',
	'renamewiki_user-page-moved' => 'Kaca $1 geus dipindahkeun ka $2.',
	'renamewiki_user-page-unmoved' => 'Kaca $1 teu bisa dipindahkeun ka $2.',
	'renamewiki_userlogpage' => 'Log ganti ngaran',
	'renamewiki_userlogpagetext' => 'Ieu minangka log parobahan ngaran pamaké',
	'renamewiki_userlogentry' => 'geus ngaganti ngaran $1 jadi "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 édit|$1 édit}}. Alesan: $2',
	'renamewiki_user-move-log' => 'Otomatis mindahkeun kaca nalika ngaganti ngaran "[[wiki_user:$1|$1]]" jadi "[[wiki_user:$2|$2]]"',
);

/** Swedish (svenska)
 * @author Ainali
 * @author Boivie
 * @author Cohan
 * @author Dafer45
 * @author Habj
 * @author Lejonel
 * @author Lokal Profil
 * @author M.M.S.
 * @author Najami
 * @author Per
 */
$messages['sv'] = array(
	'renamewiki_user' => 'Byt användarnamn',
	'renamewiki_user-linkoncontribs' => 'byt användarnamn',
	'renamewiki_user-linkoncontribs-text' => 'byt namn på denna användare',
	'renamewiki_user-desc' => "Lägger till en [[Special:Renamewiki_user|specialsida]] för att byta namn på en användare (kräver behörigheten ''renamewiki_user'')",
	'renamewiki_userold' => 'Nuvarande användarnamn:',
	'renamewiki_usernew' => 'Nytt användarnamn:',
	'renamewiki_userreason' => 'Anledning till namnbytet:',
	'renamewiki_usermove' => 'Flytta användarsidan och användardiskussionen (och deras undersidor) till det nya namnet',
	'renamewiki_usersuppress' => 'Skapa inte omdirigeringar till det nya namnet',
	'renamewiki_userreserve' => 'Reservera det gamla användarnamnet från framtida användning',
	'renamewiki_userwarnings' => 'Varningar:',
	'renamewiki_userconfirm' => 'Ja, byt namn på användaren',
	'renamewiki_usersubmit' => 'Verkställ',
	'renamewiki_user-submit-blocklog' => 'Visa blockeringslogg för användare',
	'renamewiki_usererrordoesnotexist' => 'Användaren "<nowiki>$1</nowiki>" finns inte',
	'renamewiki_usererrorexists' => 'Användaren "<nowiki>$1</nowiki>" finns redan.',
	'renamewiki_usererrorinvalid' => 'Användarnamnet "<nowiki>$1</nowiki>" är ogiltigt.',
	'renamewiki_user-error-request' => 'Ett problem inträffade i hanteringen av begäran. Gå tillbaks och försök igen.',
	'renamewiki_user-error-same-wiki_user' => 'Du kan inte byta namn på en användare till samma som tidigare.',
	'renamewiki_usersuccess' => 'Användaren "<nowiki>$1</nowiki>" har fått sitt namn bytt till "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'Sidan $1 finns redan och kan inte skrivas över automatiskt.',
	'renamewiki_user-page-moved' => 'Sidan $1 har flyttats till $2.',
	'renamewiki_user-page-unmoved' => 'Sidan $1 kunde inte flyttas till $2.',
	'renamewiki_userlogpage' => 'Logg över användarnamnsbyten',
	'renamewiki_userlogpagetext' => 'Detta är en logg över byten av användarnamn',
	'renamewiki_userlogentry' => 'bytte namn på $1 till "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 redigering|$1 redigeringar}}. Anledning: $2',
	'renamewiki_user-move-log' => 'Flyttade automatiskt sidan när namnet byttes på användaren "[[wiki_user:$1|$1]]" till "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'ändra namn på användaren',
	'right-renamewiki_user' => 'Ändra användares namn',
	'renamewiki_user-renamed-notice' => 'Användaren har fått ett nytt namn.
Som referens återfinns omdöpningsloggen nedan.',
);

/** Swahili (Kiswahili)
 * @author Kwisha
 * @author Stephenwanjau
 */
$messages['sw'] = array(
	'renamewiki_user' => 'Badili jina la mtumiaji',
	'renamewiki_user-linkoncontribs' => 'badili jina la mtumiaji',
	'renamewiki_user-linkoncontribs-text' => 'Badili jina la mtumiaji huyu',
	'renamewiki_userold' => 'Jina la sasa la mtumiaji:',
	'renamewiki_usernew' => 'Jina lipya la mtumiaji:',
	'renamewiki_userreason' => 'Sababu ya kubadili jina:',
	'renamewiki_userwarnings' => 'Ilani:',
	'renamewiki_userconfirm' => 'Ndiyo, badili jina la mtumiaji',
	'renamewiki_usersubmit' => 'Wasilisha',
	'renamewiki_user-page-moved' => 'Ukurasa wa $1 umehamishwa hadi $2.',
	'renamewiki_user-page-unmoved' => 'Ukurasa $1 haungesongezwa hadi $2.',
	'action-renamewiki_user' => 'badili jina la mtumiaji',
	'right-renamewiki_user' => 'Badili jina la watumiaji',
);

/** Tamil (தமிழ்)
 * @author Balajijagadesh
 * @author Karthi.dr
 * @author Shanmugamp7
 * @author TRYPPN
 * @author மதனாஹரன்
 */
$messages['ta'] = array(
	'renamewiki_user' => 'பயனரை பெயர்மாற்று',
	'renamewiki_user-linkoncontribs' => 'பயனரை பெயர்மாற்று',
	'renamewiki_user-linkoncontribs-text' => 'இந்த பயனரை பெயர்மாற்று',
	'renamewiki_userold' => 'தற்போதைய பயனர் பெயர்:',
	'renamewiki_usernew' => 'புதிய பயனர் பெயர்:',
	'renamewiki_userreason' => 'மறுபெயருக்கான காரணம்:',
	'renamewiki_usermove' => 'பயனர் பக்கம் மற்றும் பேச்சுப் பக்கங்களை (அவற்றின் துணைப்பக்கங்களுடன்) புதிய பெயருக்கு நகர்த்து',
	'renamewiki_usersuppress' => 'புதுப் பெயருக்கு வழிமாற்றுகளை உருவாக்க வேண்டாம்',
	'renamewiki_userreserve' => 'எதிர்காலப் பயன்பாட்டிலிருந்து பழைய பயனர் பெயரைத் தடை செய்யவும்',
	'renamewiki_userwarnings' => 'எச்சரிக்கை:',
	'renamewiki_userconfirm' => 'சரி, பயனருக்கு மாற்றுப்பெயர் கொடுக்கவும்',
	'renamewiki_usersubmit' => 'சமர்ப்பி',
	'renamewiki_user-submit-blocklog' => 'பயனாளரின் தடை உள்ளீட்டை காட்டு',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" என்ற பெயரிலான பயனர் இல்லை.',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" என்ற பெயரில் ஏற்கனவே பயனர் ஒருவர் உள்ளார்.',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" என்ற பயனர் பெயர் செல்லாது.',
	'renamewiki_user-error-request' => 'வேண்டுகோளைப் பெறுவதில் ஒரு சிக்கல்.
தயவு செய்து பின்சென்று மீண்டும் முயலவும்.',
	'renamewiki_user-error-same-wiki_user' => 'பயனர் பெயரை மாற்றும் போது அதே பெயரை நீங்கள் தரமுடியாது.',
	'renamewiki_user-page-exists' => 'பக்கம் $1 ஏற்கனவே  உள்ளது. தானாக மேலெழுத இயலாது.',
	'renamewiki_user-page-moved' => 'பக்கம் $1 $2 எனுந்தலைப்புக்கு நகர்த்தப்பட்டுள்ளது.',
	'renamewiki_user-page-unmoved' => 'பக்கம் $1 என்பதை $2 என்பதற்கு நகர்த்த முடியவில்லை.',
	'renamewiki_userlogpage' => 'பயனரை பெயர்மாற்றுதல் குறிப்பேடு',
	'renamewiki_userlogpagetext' => 'இது பயனர் பெயர் மாற்றத்திற்கான குறிப்பேடு',
	'renamewiki_userlogentry' => 'பெயர் மற்றம் செய்யப்பட்டது $1 லிருந்து "$2" க்கு',
	'renamewiki_user-log' => '{{PLURAL:$1|1 திருத்தம்|$1 திருத்தங்கள்}}. காரணம்: $2',
	'action-renamewiki_user' => 'பயனரை பெயர்மாற்று',
	'right-renamewiki_user' => 'பயனர்களை மாற்று பெயரிடு',
	'renamewiki_user-renamed-notice' => 'இந்த பயனர் பெயர் மாற்றப்பட்டது.
மாற்றுப்பெயரிடுதல் குறிப்பேடு குறிப்புதவிக்காக கீழே வழங்கப்பட்டுள்ளது',
);

/** Telugu (తెలుగు)
 * @author Chaduvari
 * @author Mpradeep
 * @author Veeven
 */
$messages['te'] = array(
	'renamewiki_user' => 'వాడుకరి పేరుమార్చు',
	'renamewiki_user-linkoncontribs' => 'వాడుకరి పేరుమార్చు',
	'renamewiki_user-linkoncontribs-text' => 'ఈ వాడుకరి పేరుని మార్చండి',
	'renamewiki_user-desc' => "వాడుకరి పేరు మార్చండి (''renamewiki_user'' అన్న అధికారం కావాలి)",
	'renamewiki_userold' => 'ప్రస్తుత వాడుకరి పేరు:',
	'renamewiki_usernew' => 'కొత్త వాడుకరి పేరు:',
	'renamewiki_userreason' => 'పేరు మార్చడానికి కారణం:',
	'renamewiki_usermove' => 'వాడుకరి పేజీ, చర్చాపేజీలను (వాటి ఉపపేజీలతో సహా) కొత్త పేరుకు తరలించండి',
	'renamewiki_usersuppress' => 'కొత్త పేరుకి దారిమార్పులు సృష్టించకు',
	'renamewiki_userreserve' => 'పాత వాడుకరిపేరుని భవిష్యత్తులో వాడకుండా నిరోధించు',
	'renamewiki_userwarnings' => 'హెచ్చరికలు:',
	'renamewiki_userconfirm' => 'అవును, వాడుకరి పేరు మార్చు',
	'renamewiki_usersubmit' => 'పంపించు',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" పేరుగల వాడుకరి లేరు.',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" పేరుతో వాడుకరి ఇప్పటికే ఉన్నారు.',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" అనే వాడుకరిపేరు సరైనది కాదు.',
	'renamewiki_user-error-request' => 'మీ అభ్యర్థనను స్వీకరించేటప్పుడు ఒక సమస్య తలెత్తింది. దయచేసి వెనక్కు వెళ్లి ఇంకోసారి ప్రయత్నించండి.',
	'renamewiki_user-error-same-wiki_user' => 'సభ్యనామాన్ని ఇంతకు ముందు ఉన్న సభ్యనామంతోనే మార్చడం కుదరదు.',
	'renamewiki_usersuccess' => '"<nowiki>$1</nowiki>" అనే సభ్యనామాన్ని "<nowiki>$2</nowiki>"గా మార్చేసాం.',
	'renamewiki_user-page-exists' => '$1 పేజీ ఇప్పటికే ఉంది, కాబట్టి ఆటోమాటిగ్గా దానిపై కొత్తపేజీని రుద్దడం కుదరదు.',
	'renamewiki_user-page-moved' => '$1 పేజీని $2 పేజీకి తరలించాం.',
	'renamewiki_user-page-unmoved' => '$1 పేజీని $2 పేజీకి తరలించలేక పోయాం.',
	'renamewiki_userlogpage' => 'వాడుకరి పేరుమార్పుల చిట్టా',
	'renamewiki_userlogpagetext' => 'ఇది వాడుకరి పేర్లకి జరిగిన మార్పుల చిట్టా.',
	'renamewiki_userlogentry' => '$1ని "$2"గా పేరు మార్చారు',
	'renamewiki_user-log' => '{{PLURAL:$1|ఒక దిద్దుబాటు|$1 దిద్దుబాట్లు}}. కారణం: $2',
	'renamewiki_user-move-log' => '"[[wiki_user:$1|$1]]" పేరును "[[wiki_user:$2|$2]]"కు మార్చడంతో పేజీని ఆటోమాటిగ్గా తరలించాం',
	'right-renamewiki_user' => 'వాడుకరుల పేరు మార్చడం',
	'renamewiki_user-renamed-notice' => 'ఈ వాడుకరి పేరు మారింది.
మీ సమాచారం కోసం పేరుమార్పుల చిట్టాని క్రింద ఇచ్చాం.',
);

/** Tetum (tetun)
 * @author MF-Warburg
 */
$messages['tet'] = array(
	'renamewiki_user' => "Fó naran foun ba uza-na'in sira",
	'renamewiki_user-desc' => "Fó naran foun ba uza-na'in sira (presiza priviléjiu ''renamewiki_user'')",
	'renamewiki_userold' => "Naran uza-na'in atuál:",
	'renamewiki_usernew' => "Naran uza-na'in foun:",
	'renamewiki_userreason' => 'Motivu:',
	'renamewiki_usermove' => "Book pájina uza-na'in no diskusaun (no sub-pájina) ba naran foun",
	'renamewiki_userconfirm' => 'Sin, fó naran foun',
	'renamewiki_usersubmit' => 'Fó naran foun',
	'renamewiki_usererrordoesnotexist' => 'Uza-na\'in "<nowiki>$1</nowiki>" la iha.',
	'renamewiki_user-page-moved' => 'Book tiha pájina $1 ba $2.',
	'renamewiki_user-page-unmoved' => 'La bele book pájina $1 ba $2.',
	'right-renamewiki_user' => "Fó naran foun ba uza-na'in sira",
);

/** Tajik (Cyrillic script) (тоҷикӣ)
 * @author Ibrahim
 */
$messages['tg-cyrl'] = array(
	'renamewiki_user' => 'Тағйири номи корбарӣ',
	'renamewiki_user-desc' => "Номи як корбарро тағйир медиҳад (ниёзманд ба ихтиёроти ''тағйирином'' аст)",
	'renamewiki_userold' => 'Номи корбари феълӣ:',
	'renamewiki_usernew' => 'Номи корбари ҷадид:',
	'renamewiki_userreason' => 'Иллати тағйири номи корбарӣ:',
	'renamewiki_usermove' => 'Саҳифаи корбарӣ ва саҳифаи баҳси корбар (ва зерсаҳифаҳои он)ро интиқол бидеҳ',
	'renamewiki_userreserve' => 'Бастани номи корбарии кӯҳна аз истифодаи оянда',
	'renamewiki_userwarnings' => 'Ҳушдорҳо:',
	'renamewiki_userconfirm' => 'Бале, номи корбариро тағйир бидеҳ',
	'renamewiki_usersubmit' => 'Сабт',
	'renamewiki_usererrordoesnotexist' => 'Номи корбарӣ "<nowiki>$1</nowiki>" вуҷуд надорад.',
	'renamewiki_usererrorexists' => 'Номи корбарӣ "<nowiki>$1</nowiki>" истифода шудааст.',
	'renamewiki_usererrorinvalid' => 'Номи корбарӣ "<nowiki>$1</nowiki>" ғайри миҷоз аст.',
	'renamewiki_user-error-request' => 'Дар дарёфти дархост мушкилие пеш омад. Лутфан ба саҳифаи қаблӣ бозгардед ва дубора талош кунед.',
	'renamewiki_user-error-same-wiki_user' => 'Шумо наметавонед номи як корбарро ба ҳамон номи қаблиаш тағйир диҳед.',
	'renamewiki_usersuccess' => 'Номи корбар "<nowiki>$1</nowiki>" ба "<nowiki>$2</nowiki>" тағйир ёфт.',
	'renamewiki_user-page-exists' => 'Саҳифаи $1 аллакай вуҷуд дорда ва ба таври худкор қобили бознависӣ нест.',
	'renamewiki_user-page-moved' => 'Саҳифаи $1 ба $2 кӯчонида шуд.',
	'renamewiki_user-page-unmoved' => 'Имкони кӯчонидани саҳифаи $1 ба $2 вуҷуд надорад.',
	'renamewiki_userlogpage' => 'Гузориши тағйири номи корбар',
	'renamewiki_userlogpagetext' => 'Ин гузориши тағйири номи корбарон аст',
	'renamewiki_userlogentry' => 'номи $1ро ба "$2" тағйир дод',
	'renamewiki_user-log' => '{{PLURAL:$1|1 вироиш|$1 вироишҳо}}. Далел: $2',
	'renamewiki_user-move-log' => 'Саҳифа дар вақти тағйири номи корбар  "[[wiki_user:$1|$1]]" ба "[[wiki_user:$2|$2]]" ба таври худкор кӯчонида шуд',
	'right-renamewiki_user' => 'Тағйири номи корбарон',
);

/** Tajik (Latin script) (tojikī)
 * @author Liangent
 */
$messages['tg-latn'] = array(
	'renamewiki_user' => 'Taƣjiri nomi korbarī',
	'renamewiki_user-desc' => "Nomi jak korbarro taƣjir medihad (nijozmand ba ixtijoroti ''taƣjirinom'' ast)",
	'renamewiki_userold' => "Nomi korbari fe'lī:",
	'renamewiki_usernew' => 'Nomi korbari çadid:',
	'renamewiki_userreason' => 'Illati taƣjiri nomi korbarī:',
	'renamewiki_usermove' => 'Sahifai korbarī va sahifai bahsi korbar (va zersahifahoi on)ro intiqol bideh',
	'renamewiki_userreserve' => 'Bastani nomi korbariji kūhna az istifodai ojanda',
	'renamewiki_userwarnings' => 'Huşdorho:',
	'renamewiki_userconfirm' => 'Bale, nomi korbariro taƣjir bideh',
	'renamewiki_usersubmit' => 'Sabt',
	'renamewiki_usererrordoesnotexist' => 'Nomi korbarī "<nowiki>$1</nowiki>" vuçud nadorad.',
	'renamewiki_usererrorexists' => 'Nomi korbarī "<nowiki>$1</nowiki>" istifoda şudaast.',
	'renamewiki_usererrorinvalid' => 'Nomi korbarī "<nowiki>$1</nowiki>" ƣajri miçoz ast.',
	'renamewiki_user-error-request' => 'Dar darjofti darxost muşkilie peş omad. Lutfan ba sahifai qablī bozgarded va dubora taloş kuned.',
	'renamewiki_user-error-same-wiki_user' => 'Şumo nametavoned nomi jak korbarro ba hamon nomi qabliaş taƣjir dihed.',
	'renamewiki_usersuccess' => 'Nomi korbar "<nowiki>$1</nowiki>" ba "<nowiki>$2</nowiki>" taƣjir joft.',
	'renamewiki_user-page-exists' => 'Sahifai $1 allakaj vuçud dorda va ba tavri xudkor qobili boznavisī nest.',
	'renamewiki_user-page-moved' => 'Sahifai $1 ba $2 kūconida şud.',
	'renamewiki_user-page-unmoved' => 'Imkoni kūconidani sahifai $1 ba $2 vuçud nadorad.',
	'renamewiki_userlogpage' => 'Guzorişi taƣjiri nomi korbar',
	'renamewiki_userlogpagetext' => 'In guzorişi taƣjiri nomi korbaron ast',
	'renamewiki_user-log' => '{{PLURAL:$1|1 viroiş|$1 viroişho}}. Dalel: $2',
	'renamewiki_user-move-log' => 'Sahifa dar vaqti taƣjiri nomi korbar  "[[wiki_user:$1|$1]]" ba "[[wiki_user:$2|$2]]" ba tavri xudkor kūconida şud',
	'right-renamewiki_user' => 'Taƣjiri nomi korbaron',
);

/** Thai (ไทย)
 * @author Harley Hartwell
 * @author Mopza
 * @author Passawuth
 */
$messages['th'] = array(
	'renamewiki_user' => 'เปลี่ยนชื่อผู้ใช้',
	'renamewiki_user-desc' => "เพิ่ม[[Special:Renamewiki_user|หน้าพิเศษ]] สำหรับเปลี่ยนชื่อผู้ใช้ (ต้องมีสิทธิ์ ''renamewiki_user'' (เปลี่ยนชื่อผู้ใช้))",
	'renamewiki_userold' => 'ชื่อผู้ใช้ปัจจุบัน:',
	'renamewiki_usernew' => 'ชื่อผู้ใช้ใหม่:',
	'renamewiki_userreason' => 'เหตุผลในการเปลี่ยนชื่อ:',
	'renamewiki_usermove' => 'ย้ายหน้าผู้ใช้และหน้าพูดคุย (รวมถึงหน้าย่อยด้วย) ไปยังชื่อใหม่',
	'renamewiki_userreserve' => 'บล็อกชื่อผู้ใช้เดิมจากการใช้งานในอนาคต',
	'renamewiki_userwarnings' => 'คำเตือน:',
	'renamewiki_userconfirm' => 'ใช่, เปลี่ยนชื่อผู้ใช้นี้',
	'renamewiki_usersubmit' => 'ตกลง',
	'renamewiki_usererrordoesnotexist' => 'ไม่พบผู้ใช้ "<nowiki>$1</nowiki>" ในระบบ',
	'renamewiki_usererrorexists' => 'มีผู้ใช้ "<nowiki>$1</nowiki>" อยู่แล้ว',
	'renamewiki_usererrorinvalid' => 'ไม่สามารถใช้ชื่อผู้ใช้ "<nowiki>$1</nowiki>" ได้',
	'renamewiki_user-error-request' => 'มีปัญหาเกิดขึ้นเกี่ยวกับการรับคำเรียกร้องของคุณ กรุณากลับไปที่หน้าเดิม และ พยายามอีกครั้ง',
	'renamewiki_user-error-same-wiki_user' => 'ไม่สามารถเปลี่ยนชื่อผู้ใช้ได้เนื่องจากมีชื่อผู้ใช้นี้อยู่ก่อนแล้ว',
	'renamewiki_usersuccess' => 'ผู้ใช้:<nowiki>$1</nowiki> ถูกเปลี่ยนชื่อเป็น ผู้ใช้:<nowiki>$2</nowiki> เรียบร้อยแล้ว',
	'renamewiki_user-page-exists' => 'หน้า $1 มีอยู่แล้ว และไม่สามารถย้ายไปแทนที่ได้โดยอัตโนมัติ',
	'renamewiki_user-page-moved' => 'หน้า $1 ถูกย้ายไปยัง $2',
	'renamewiki_user-page-unmoved' => 'ไม่สามารถย้ายหน้า $1 ไปยัง $2 ได้',
	'renamewiki_userlogpage' => 'ปูมการเปลี่ยนชื่อผู้ใช้',
	'renamewiki_userlogpagetext' => 'ข้อมูลการเปลี่ยนชื่อผู้ใช้',
	'renamewiki_userlogentry' => 'ได้เปลี่ยนชื่อ $1 ไปเป็น [[ผู้ใช้:$2]]',
	'renamewiki_user-log' => 'แก้ไขแล้ว $1 ครั้ง เหตุผล: $2',
	'renamewiki_user-move-log' => 'ย้ายโดยอัตโนมัติ ขณะเปลี่ยนชื่อผู้ใช้จาก "[[wiki_user:$1|$1]]" เป็น "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'เปลี่ยนชื่อผู้ใช้',
	'renamewiki_user-renamed-notice' => 'ผู้ใช้นี้ได้ถูกเปลี่ยนชื่อ บันทึกการเปลี่ยนชื่อแสดงอยู่ด้านล่างสำหรับการอ้างอิง',
);

/** Turkmen (Türkmençe)
 * @author Hanberke
 */
$messages['tk'] = array(
	'renamewiki_user' => 'Ulanyjy adyny üýtget',
	'renamewiki_user-linkoncontribs' => 'ulanyjy adyny üýtget',
	'renamewiki_user-linkoncontribs-text' => 'Bu ulanyjynyň adyny üýtget',
	'renamewiki_user-desc' => "Ulanyjyny täzeden atlandyrmak üçin [[Special:Renamewiki_user|ýörite sahypa]] goşýar (''ulanyjynytäzedenatlandyr'' hukugy gerek)",
	'renamewiki_userold' => 'Häzirki ulanyjy ady:',
	'renamewiki_usernew' => 'Täze ulanyjy ady:',
	'renamewiki_userreason' => 'At üýtgetmegiň sebäbi:',
	'renamewiki_usermove' => 'Ulanyjy we pikir alyşma sahypalaryny (we kiçi sahypalaryny) täze ada geçir',
	'renamewiki_usersuppress' => 'Täze ada gönükdirmeler döretme',
	'renamewiki_userreserve' => 'Köne ulanyjy adyny indi ulanylmakdan blokirle',
	'renamewiki_userwarnings' => 'Duýduryşlar:',
	'renamewiki_userconfirm' => 'Hawa, ulanyjynyň adyny üýtget',
	'renamewiki_usersubmit' => 'Tabşyr',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" atly ulanyjy ýok.',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" ulanyjysy eýýäm bar.',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" ulanyjy ady nädogry.',
	'renamewiki_user-error-request' => 'Talaby almak bilen baglanyşykyly bir probleme ýüze çykdy.
Yza gaýdyp gaýtadan synanyşyp görüň.',
	'renamewiki_user-error-same-wiki_user' => 'Ulanyja öňküsi ýaly bir ada täzeden geçirip bilmeýärsiňiz.',
	'renamewiki_usersuccess' => 'Ulanyjy "<nowiki>$1</nowiki>" täze ada geçirildi: "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => '$1 sahypasy eýýäm bar we onuň üstüne awtomatik ýazyp bolmaýar.',
	'renamewiki_user-page-moved' => '$1 sahypasy $2 sahypasyna geçirildi.',
	'renamewiki_user-page-unmoved' => '$1 sahypasyny $2 sahypasyna geçirip bolmaýar.',
	'renamewiki_userlogpage' => 'Ulanyjy adyny üýtgetme gündeligi',
	'renamewiki_userlogpagetext' => 'Bu gündelik ulanyjy ady üýtgetmelerini görkezýär.',
	'renamewiki_userlogentry' => '$1 täzeden atlandyryldy: "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 özgerdiş|$1 özgerdiş}}. Sebäp: $2',
	'renamewiki_user-move-log' => 'Ulanyjy "[[wiki_user:$1|$1]]" adyndan "[[wiki_user:$2|$2]]" adyna täzeden atlandyrylanda, sahypa awtomatik geçirildi',
	'right-renamewiki_user' => 'Ulanyjylaryň adyny üýtget',
	'renamewiki_user-renamed-notice' => 'Bu ulanyjynyň ady üýtgedilipdir.
At üýtgediş gündeligi aşakda salgylanma üçin berilýär.',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'renamewiki_user' => 'Muling pangalanan ang tagagamit',
	'renamewiki_user-linkoncontribs' => 'muling pangalanan ang tagagamit',
	'renamewiki_user-linkoncontribs-text' => 'muling pangalanan ang tagagamit na ito',
	'renamewiki_user-desc' => "Nagdaragdag ng isang [[Special:Renamewiki_user|natatanging pahina]] para mapangalanang muli ang isang tagagamit (kailangang ang karapatang ''pangalanangmuliangtagagamit'')",
	'renamewiki_userold' => 'Pangkasalukuyang pangalan ng tagagamit:',
	'renamewiki_usernew' => 'Bagong pangalan ng tagagamit:',
	'renamewiki_userreason' => 'Dahil para sa muling pagpapangalan:',
	'renamewiki_usermove' => 'Ilipat ang mga pahina ng tagagamit at pangusapan (at mga kabahaging pahina nila) patungo sa bagong pangalan',
	'renamewiki_usersuppress' => 'Huwag lumikha ng mga pagpapapunta sa bagong  pangalan',
	'renamewiki_userreserve' => 'Hadlangan ang dating pangalan ng tagagamit mula sa muling paggamit sa hinaharap',
	'renamewiki_userwarnings' => 'Mga babala:',
	'renamewiki_userconfirm' => 'Oo, pangalanang muli ang tagagamit',
	'renamewiki_usersubmit' => 'Ipasa',
	'renamewiki_user-submit-blocklog' => 'Ipakita ang talaan ng pagharang para sa tagagamit',
	'renamewiki_usererrordoesnotexist' => 'Hindi pa umiiral ang tagagamit na "<nowiki>$1</nowiki>".',
	'renamewiki_usererrorexists' => 'Umiiral na ang tagagamit na "<nowiki>$1</nowiki>".',
	'renamewiki_usererrorinvalid' => 'Hindi tanggap ang pangalan ng tagagamit na "<nowiki>$1</nowiki>".',
	'renamewiki_user-error-request' => 'Nagkaroon ng isang suliranin sa pagtanggap ng kahilingan.
Magbalik lamang at subukan uli.',
	'renamewiki_user-error-same-wiki_user' => 'Hindi mo maaaring pangalanang muli ang tagagamit patungo sa kaparehong bagay na katulad ng dati.',
	'renamewiki_usersuccess' => 'Ang tagagamit na "<nowiki>$1</nowiki>" ay muling napangalanan na patungong "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Umiiral na ang pahinang $1 at hindi maaaring kusang mapatungan.',
	'renamewiki_user-page-moved' => 'Ang pahinang $1 ay nailipat na patungo sa $2.',
	'renamewiki_user-page-unmoved' => 'Hindi mailipat ang pahinang $1 patungo sa $2.',
	'renamewiki_userlogpage' => 'Talaan ng muling pagpapangalan ng tagagamit',
	'renamewiki_userlogpagetext' => 'Isa itong pagtatala/talaan ng mga pagbabago sa mga pangalan ng tagagamit.',
	'renamewiki_userlogentry' => 'muling pinangalan si $1 patungo sa "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 pagbabago|$1 mga pagbabago}}. Dahilan: $2',
	'renamewiki_user-move-log' => 'Kusang inilipat ang pahina habang muling pinapangalanan ang tagagamit na si "[[wiki_user:$1|$1]]" patungo sa "[[wiki_user:$2|$2]]"',
	'action-renamewiki_user' => 'muling pangalanan ang mga tagagamit',
	'right-renamewiki_user' => 'Muling pangalanan ang mga tagagamit',
	'renamewiki_user-renamed-notice' => 'Napangalanan nang muli ang tagagamit na ito.
Ibinigay sa ibaba ang talaan ng pagpapangalang muli para masangguni.',
);

/** Tongan (lea faka-Tonga) */
$messages['to'] = array(
	'renamewiki_user' => 'Liliu hingoa ʻo e ʻetita',
	'renamewiki_userold' => 'Hingoa motuʻa ʻo e ʻetita:',
	'renamewiki_usernew' => 'Hingoa foʻou ʻo e ʻetita:',
	'renamewiki_usersubmit' => 'Fai ā liliuhingoa',
	'renamewiki_usererrordoesnotexist' => 'Ko e ʻetita "<nowiki>$1</nowiki>" ʻoku ʻikai toka tuʻu ia',
	'renamewiki_usererrorexists' => 'Ko e ʻetita "<nowiki>$1</nowiki>" ʻoku toka tuʻu ia',
	'renamewiki_usererrorinvalid' => 'ʻOku taʻeʻaonga ʻa e hingoa fakaʻetita ko "<nowiki>$1</nowiki>"',
	'renamewiki_usersuccess' => 'Ko e ʻetita "<nowiki>$1</nowiki>" kuo liliuhingoa ia kia "<nowiki>$2</nowiki>"',
	'renamewiki_userlogpage' => 'Tohinoa ʻo e liliu he hingoa ʻo e ʻetita',
	'renamewiki_userlogpagetext' => 'Ko e tohinoa ʻeni ʻo e ngaahi liliu ki he hingoa ʻo e kau ʻetita',
);

/** Turkish (Türkçe)
 * @author Joseph
 * @author Karduelis
 * @author Runningfridgesrule
 * @author Uğur Başak
 * @author Vito Genovese
 */
$messages['tr'] = array(
	'renamewiki_user' => 'Kullanıcı adı değiştir',
	'renamewiki_user-linkoncontribs' => 'kullanıcıyı yeniden adlandır',
	'renamewiki_user-linkoncontribs-text' => 'Bu kullanıcıyı yeniden adlandır',
	'renamewiki_user-desc' => "Kullanıcıyı yeniden adlandırmak için bir [[Special:Renamewiki_user|özel sayfa]] ekler (''kullanıcıyıyenidenadlandır'' hakkı gerekir)",
	'renamewiki_userold' => 'Şu anda ki kullanıcı adı:',
	'renamewiki_usernew' => 'Yeni kullanıcı adı:',
	'renamewiki_userreason' => 'Neden:',
	'renamewiki_usermove' => 'Kullanıcı ve tartışma sayfalarını (ve alt sayfalarını) yeni isme taşı',
	'renamewiki_usersuppress' => 'Yeni ada yönlendirmeler oluşturma',
	'renamewiki_userreserve' => 'Eski kullanıcı adını ilerdeki kullanımlar için engelle',
	'renamewiki_userwarnings' => 'Uyarılar:',
	'renamewiki_userconfirm' => 'Evet, kullanıcıyı yeniden adlandır',
	'renamewiki_usersubmit' => 'Gönder',
	'renamewiki_usererrordoesnotexist' => '"<nowiki>$1</nowiki>" adlı kullanıcı bulunmamaktadır.',
	'renamewiki_usererrorexists' => '"<nowiki>$1</nowiki>" kullanıcısı zaten mevcut.',
	'renamewiki_usererrorinvalid' => '"<nowiki>$1</nowiki>" kullanıcı adı geçersiz.',
	'renamewiki_user-error-request' => 'İsteğin alımıyla ilgili bir problem var.
Lütfen geri dönüp tekrar deneyin.',
	'renamewiki_user-error-same-wiki_user' => 'Bir kullanıcıyı eskiden olduğu isme yeniden adlandıramazsınız.',
	'renamewiki_usersuccess' => 'Daha önce "<nowiki>$1</nowiki>" olarak kayıtlı kullanıcının rumuzu "<nowiki>$2</nowiki>" olarak değiştirilmiştir.',
	'renamewiki_user-page-exists' => '$1 sayfası zaten mevcut ve otomatik olarak üstüne yazılamaz.',
	'renamewiki_user-page-moved' => '$1 sayfası $2 sayfasına taşındı.',
	'renamewiki_user-page-unmoved' => '$1 sayfası $2 sayfasına taşınamıyor.',
	'renamewiki_userlogpage' => 'Kullanıcı adı değişikliği kayıtları',
	'renamewiki_userlogpagetext' => 'Aşağıda bulunan liste adı değiştirilmiş kullanıcıları gösterir.',
	'renamewiki_userlogentry' => '$1, "$2" olarak yeniden adlandırıldı',
	'renamewiki_user-log' => '{{PLURAL:$1|1 düzenleme|$1 düzenleme}}. Neden: $2',
	'renamewiki_user-move-log' => 'Kullanıcıyı "[[wiki_user:$1|$1]]" isminden "[[wiki_user:$2|$2]]" ismine yeniden adlandırırken, sayfa otomatik olarak taşındı',
	'right-renamewiki_user' => 'Kullanıcıların adlarını değiştirir',
	'renamewiki_user-renamed-notice' => 'Bu kullanıcının adı değiştirildi.
Referans için ad değiştirme günlüğü aşağıda sağlanmıştır.',
);

/** Ukrainian (українська)
 * @author A1
 * @author AS
 * @author Ahonc
 * @author EugeneZelenko
 * @author Microcell
 * @author Prima klasy4na
 * @author Тест
 */
$messages['uk'] = array(
	'renamewiki_user' => 'Перейменувати користувача',
	'renamewiki_user-linkoncontribs' => 'перейменувати користувача',
	'renamewiki_user-linkoncontribs-text' => 'Перейменувати цього користувача',
	'renamewiki_user-desc' => "Перейменування користувача (потрібні права ''renamewiki_user'')",
	'renamewiki_userold' => "Поточне ім'я:",
	'renamewiki_usernew' => "Нове ім'я:",
	'renamewiki_userreason' => 'Причина перейменування:',
	'renamewiki_usermove' => 'Перейменувати також сторінку користувача, сторінку обговорення та їхні підсторінки',
	'renamewiki_usersuppress' => 'Не створюйте перенаправлення на нову назву',
	'renamewiki_userreserve' => "Зарезервувати старе ім'я користувача для подальшого використання",
	'renamewiki_userwarnings' => 'Попередження:',
	'renamewiki_userconfirm' => 'Так, перейменувати користувача',
	'renamewiki_usersubmit' => 'Виконати',
	'renamewiki_user-submit-blocklog' => 'Показати журнал блокувань користувача',
	'renamewiki_usererrordoesnotexist' => 'Користувач з іменем «<nowiki>$1</nowiki>» не зареєстрований.',
	'renamewiki_usererrorexists' => 'Користувач з іменем «<nowiki>$1</nowiki>» уже зареєстрований.',
	'renamewiki_usererrorinvalid' => "Недопустиме ім'я користувача: <nowiki>$1</nowiki>.",
	'renamewiki_user-error-request' => 'Виникли ускладнення з отриманням запиту. Будь ласка, поверніться назад і повторіть іще раз.',
	'renamewiki_user-error-same-wiki_user' => "Ви не можете змінити ім'я користувача на те саме, що було раніше.",
	'renamewiki_usersuccess' => 'Користувач «<nowiki>$1</nowiki>» був перейменований на «<nowiki>$2</nowiki>».',
	'renamewiki_user-page-exists' => 'Сторінка $1 вже існує і не може бути перезаписана автоматично.',
	'renamewiki_user-page-moved' => 'Сторінка $1 була перейменована на $2.',
	'renamewiki_user-page-unmoved' => 'Сторінка $1 не може бути перейменована на $2.',
	'renamewiki_userlogpage' => 'Журнал перейменувань користувачів',
	'renamewiki_userlogpagetext' => 'Це журнал здійснених перейменувань зареєстрованих користувачів.',
	'renamewiki_userlogentry' => 'перейменував $1 на «$2»',
	'renamewiki_user-log' => 'мав $1 {{PLURAL:$1|редагування|редагування|редагувань}}. Причина: $2',
	'renamewiki_user-move-log' => 'Автоматичне перейменування сторінки при перейменуванні користувача «[[wiki_user:$1|$1]]» на «[[wiki_user:$2|$2]]»',
	'action-renamewiki_user' => 'перейменування користувачів',
	'right-renamewiki_user' => 'Перейменування користувачів',
	'renamewiki_user-renamed-notice' => 'Цей користувач був перейменований.
Для довідки нижче наведений журнал перейменувань.',
);

/** Urdu (اردو)
 * @author පසිඳු කාවින්ද
 */
$messages['ur'] = array(
	'renamewiki_user' => 'صارف کا نام تبدیل کریں',
	'renamewiki_userwarnings' => 'انتباہ:',
	'renamewiki_usersubmit' => 'جمع کرائیں',
	'renamewiki_user-log' => 'جن کی $1 ترامیم تھیں. $2',
	'action-renamewiki_user' => 'صارفین کو نیا نام دیںکے',
	'right-renamewiki_user' => 'صارفین کو نیا نام دیںکے',
);

/** Uzbek (oʻzbekcha)
 * @author CoderSI
 */
$messages['uz'] = array(
	'renamewiki_userlogpage' => 'Ishtirokchilarni qayta nomlash qaydlari',
	'renamewiki_userlogentry' => '"$1"ni "$2"ga qayta nomladi',
);

/** vèneto (vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'renamewiki_user' => 'Rinomina utente',
	'renamewiki_user-linkoncontribs' => 'rinomina utente',
	'renamewiki_user-linkoncontribs-text' => 'Rinomina sto utente',
	'renamewiki_user-desc' => "Funsion par rinominar un utente (ghe vole i diriti de ''renamewiki_user'')",
	'renamewiki_userold' => 'Vecio nome utente:',
	'renamewiki_usernew' => 'Novo nome utente:',
	'renamewiki_userreason' => 'Motivo del canbio nome',
	'renamewiki_usermove' => 'Rinomina anca la pagina utente, la pagina de discussion e le relative sotopagine',
	'renamewiki_usersuppress' => 'No stà crear rimandi al nome novo',
	'renamewiki_userreserve' => "Tien da conto el vecio nome utente par inpedir che'l vegna doparà in futuro",
	'renamewiki_userwarnings' => 'Avertimenti:',
	'renamewiki_userconfirm' => "Sì, rinomina l'utente",
	'renamewiki_usersubmit' => 'Invia',
	'renamewiki_usererrordoesnotexist' => 'El nome utente "<nowiki>$1</nowiki>" no l\'esiste',
	'renamewiki_usererrorexists' => 'El nome utente "<nowiki>$1</nowiki>" l\'esiste de zà',
	'renamewiki_usererrorinvalid' => 'El nome utente "<nowiki>$1</nowiki>" no\'l xe mìa valido.',
	'renamewiki_user-error-request' => 'Se gà verificà un problema ne la ricezion de la richiesta. Torna indrìo e ripróa da novo.',
	'renamewiki_user-error-same-wiki_user' => "No se pol rinominar un utente al stesso nome che'l gavea zà.",
	'renamewiki_usersuccess' => 'El nome utente "<nowiki>$1</nowiki>" el xe stà canbià in "<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => 'La pagina $1 la esiste de zà; no se pole sovrascrìvarla automaticamente.',
	'renamewiki_user-page-moved' => 'La pagina $1 la xe stà spostà a $2.',
	'renamewiki_user-page-unmoved' => 'No se pole spostar la pagina $1 a $2.',
	'renamewiki_userlogpage' => 'Registro dei utenti rinominà',
	'renamewiki_userlogpagetext' => 'De seguito vien presentà el registro de le modifiche ai nomi utente',
	'renamewiki_userlogentry' => 'gà rinominà $1 in "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 contributo|$1 contributi}}. Motivo: $2',
	'renamewiki_user-move-log' => 'Spostamento automatico de la pagina - utente rinominà da "[[wiki_user:$1|$1]]" a "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'Rinomina utenti',
	'renamewiki_user-renamed-notice' => 'Sto utente el gà canbià nome.
Qua soto ghe xe el riferimento sul registro de rinomina.',
);

/** Veps (vepsän kel’)
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'renamewiki_user' => 'Udesnimitada kävutajad',
	'renamewiki_userold' => 'Nügüdläine kävutajannimi:',
	'renamewiki_usernew' => "Uz' kävutajan nimi:",
	'renamewiki_userreason' => 'Udesnimitandan sü:',
	'renamewiki_usersubmit' => 'Tehta',
	'right-renamewiki_user' => 'Udesnimitada kävutajid',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'renamewiki_user' => 'Đổi tên thành viên',
	'renamewiki_user-linkoncontribs' => 'đổi tên thành viên',
	'renamewiki_user-linkoncontribs-text' => 'Đổi tên thành viên này',
	'renamewiki_user-desc' => "Đổi tên thành viên (cần có quyền ''renamewiki_user'')",
	'renamewiki_userold' => 'Tên hiệu hiện nay:',
	'renamewiki_usernew' => 'Tên hiệu mới:',
	'renamewiki_userreason' => 'Lý do đổi tên:',
	'renamewiki_usermove' => 'Di chuyển trang thành viên và thảo luận thành viên (cùng với trang con của nó) sang tên mới',
	'renamewiki_usersuppress' => 'Không tạo trang đổi hướng đến tên mới',
	'renamewiki_userreserve' => 'Không cho phép ai lấy tên cũ',
	'renamewiki_userwarnings' => 'Cảnh báo:',
	'renamewiki_userconfirm' => 'Đổi tên người dùng',
	'renamewiki_usersubmit' => 'Thực hiện',
	'renamewiki_user-submit-blocklog' => 'Xem nhật trình cấm người dùng',
	'renamewiki_usererrordoesnotexist' => 'Thành viên “<nowiki>$1</nowiki>” không tồn tại.',
	'renamewiki_usererrorexists' => 'Thành viên “<nowiki>$1</nowiki>” đã hiện hữu.',
	'renamewiki_usererrorinvalid' => 'Tên thành viên “<nowiki>$1</nowiki>” không hợp lệ.',
	'renamewiki_user-error-request' => 'Có trục trặc trong tiếp nhận yêu cầu. Xin hãy quay lại và thử lần nữa.',
	'renamewiki_user-error-same-wiki_user' => 'Bạn không thể đổi tên thành viên sang tên y hệt như vậy.',
	'renamewiki_usersuccess' => 'Thành viên “<nowiki>$1</nowiki>” đã được đổi tên thành “<nowiki>$2</nowiki>”.',
	'renamewiki_user-page-exists' => 'Trang $1 đã tồn tại và không thể bị tự động ghi đè.',
	'renamewiki_user-page-moved' => 'Trang $1 đã được di chuyển đến $2.',
	'renamewiki_user-page-unmoved' => 'Trang $1 không thể di chuyển đến $2.',
	'renamewiki_userlogpage' => 'Nhật trình đổi tên thành viên',
	'renamewiki_userlogpagetext' => 'Đây là nhật trình ghi lại các thay đổi đối với tên thành viên',
	'renamewiki_userlogentry' => 'đã đổi tên $1 thành “$2”',
	'renamewiki_user-log' => 'Đã có {{PLURAL:$1|1 sửa đổi|$1 sửa đổi}}. Lý do: $2',
	'renamewiki_user-move-log' => 'Đã tự động di chuyển trang khi đổi tên thành viên “[[wiki_user:$1|$1]]” thành “[[wiki_user:$2|$2]]”',
	'action-renamewiki_user' => 'đổi tên thành viên',
	'right-renamewiki_user' => 'Đổi tên thành viên',
	'renamewiki_user-renamed-notice' => 'Thành viên này đã được đổi tên.
Nhật trình đổi tên được ghi ở dưới để tiện theo dõi.',
);

/** Volapük (Volapük)
 * @author Malafaya
 * @author Smeira
 */
$messages['vo'] = array(
	'renamewiki_user' => 'Votanemön gebani',
	'renamewiki_user-linkoncontribs' => 'votanemön gebani',
	'renamewiki_user-linkoncontribs-text' => 'Votanemön gebani at',
	'renamewiki_user-desc' => "Votanemön gebani (gität: ''renamewiki_user'' zesüdon)",
	'renamewiki_userold' => 'Gebananem anuik:',
	'renamewiki_usernew' => 'Gebananem nulik:',
	'renamewiki_userreason' => 'Kod votanemama:',
	'renamewiki_usermove' => 'Topätükön padi e bespikapadi gebana (e donapadis onsik) ad nem nulik',
	'renamewiki_userreserve' => 'Neletön gebananemi rigik (pos votanemam) ad pagebön ün fütür',
	'renamewiki_userwarnings' => 'Nuneds:',
	'renamewiki_userconfirm' => 'Si, votanemolös gebani',
	'renamewiki_usersubmit' => 'Sedön',
	'renamewiki_usererrordoesnotexist' => 'Geban: "<nowiki>$1</nowiki>" no dabinon.',
	'renamewiki_usererrorexists' => 'Geban: "<nowiki>$1</nowiki>" ya dabinon.',
	'renamewiki_usererrorinvalid' => 'Gebananem: "<nowiki>$1</nowiki>" no lonöfon.',
	'renamewiki_user-error-request' => 'Ädabinon säkäd pö daget bega. Geikolös, begö! e steifülolös dönu.',
	'renamewiki_user-error-same-wiki_user' => 'No kanol votanemön gebani ad nem ot.',
	'renamewiki_usersuccess' => 'Geban: "<nowiki>$1</nowiki>" pevotanemon ad "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => 'Pad: $1 ya dabinon e no kanon pamoükön itjäfidiko.',
	'renamewiki_user-page-moved' => 'Pad: $1 petopätükon ad pad: $2.',
	'renamewiki_user-page-unmoved' => 'No eplöpos ad topätükön padi: $1 ad pad: $2.',
	'renamewiki_userlogpage' => 'Jenotalised votanemamas',
	'renamewiki_userlogpagetext' => 'Is palisedons votükams gebananemas.',
	'renamewiki_userlogentry' => 'evotanemon eli $1 ad "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|Redakam 1|Redakams $1}}. Kod: $2',
	'renamewiki_user-move-log' => 'Pad petopätükon itjäfidiko dü votanemama gebana: "[[wiki_user:$1|$1]]" ad "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'Votanemön gebanis',
);

/** Walloon (walon)
 * @author Srtxg
 */
$messages['wa'] = array(
	'renamewiki_user' => 'Rilomer èn uzeu',
	'renamewiki_userold' => "No d' elodjaedje pol moumint:",
	'renamewiki_usernew' => "Novea no d' elodjaedje:",
	'renamewiki_userreason' => 'Råjhon pol rilomaedje:',
	'renamewiki_usermove' => "Displaecî les pådjes d' uzeu et d' copene (eyet leus dzo-pådjes) viè l' novea no",
	'renamewiki_userwarnings' => 'Adviertixhmints:',
	'renamewiki_usersubmit' => 'Evoye',
	'renamewiki_usererrordoesnotexist' => "L' uzeu «<nowiki>$1</nowiki>» n' egzistêye nén",
	'renamewiki_usererrorexists' => "L' uzeu «<nowiki>$1</nowiki>» egzistêye dedja",
	'renamewiki_usererrorinvalid' => "Li no d' elodjaedje «<nowiki>$1</nowiki>» n' est nén on no valide",
	'renamewiki_usersuccess' => "L' uzeu «<nowiki>$1</nowiki>» a stî rlomé a «<nowiki>$2</nowiki>»",
	'renamewiki_user-page-exists' => "Li pådje $1 egzistêye dedja et n' pout nén esse otomaticmint spotcheye.",
	'renamewiki_user-page-moved' => 'Li pådje $1 a stî displaeceye viè $2.',
	'renamewiki_user-page-unmoved' => 'Li pådje $1 èn pout nén esse displaeceye viè $2.',
	'renamewiki_userlogpage' => "Djournå des candjmints d' no d' uzeus",
	'renamewiki_userlogpagetext' => "Chal pa dzo c' est ene djivêye des uzeus k' ont candjî leu no d' elodjaedje.",
	'renamewiki_user-log' => "k' aveut ddja fwait $1 candjmints. $2",
	'renamewiki_user-move-log' => "Pådje displaeceye otomaticmint tot rlomant l' uzeu «[[wiki_user:$1|$1]]» viè «[[wiki_user:$2|$2]]»",
);

/** Yiddish (ייִדיש)
 * @author פוילישער
 */
$messages['yi'] = array(
	'renamewiki_user' => 'בײַטן באַניצער נאָמען',
	'renamewiki_user-linkoncontribs' => 'בײַטן באַניצער נאָמען',
	'renamewiki_user-linkoncontribs-text' => 'בײַטן נאָמען פֿון דעם באַניצער',
	'renamewiki_user-desc' => "לייגט צו א [[Special:Renamewiki_user|באַזונדערן בלאַט]] צו בײַטן א באַניצער נאָמען (פֿאדערט ''renamewiki_user'' רעכט)",
	'renamewiki_userold' => 'לויפיגער באַניצער-נאָמען:',
	'renamewiki_usernew' => 'נײַער באַניצער-נאָמען:',
	'renamewiki_userreason' => 'סיבה פֿאַר ענדערן נאָמען:',
	'renamewiki_usermove' => 'באַוועגן באַניצער און שמועס בלעטער (מיט זייערע אונטערבלעטער) צו נײַעם נאָמען',
	'renamewiki_usersuppress' => 'שאַפֿט נישט קיין ווייטערפֿירונגען צום נײַעם נאָמען',
	'renamewiki_userreserve' => 'בלאקירן דעם אַלטן באַניצער־נאָמען פֿון נוץ אין צוקונפֿט',
	'renamewiki_userwarnings' => 'ווארענונגען:',
	'renamewiki_userconfirm' => 'יאָ, ענדער דעם באַניצער־נאָמען',
	'renamewiki_usersubmit' => 'אײַנגעבן',
	'renamewiki_usererrordoesnotexist' => 'דער באַניצער "<nowiki>$1</nowiki>" עקזיסטירט נישט.',
	'renamewiki_usererrorexists' => 'דער באַניצער "<nowiki>$1</nowiki>" עקזיסטירט שוין.',
	'renamewiki_usererrorinvalid' => 'דער באַניצער נאָמען  "<nowiki>$1</nowiki>" איז נישט גילטיק.',
	'renamewiki_user-error-request' => 'געווען א פראבלעם מיט באַקומען די בקשה.
ביטע גייט צוריק און פרואווט ווידעראַמאָל.',
	'renamewiki_user-error-same-wiki_user' => 'מען קען נישט ענדערן א באַניצער צום זעלבן נאָמען ווי פֿריער.',
	'renamewiki_usersuccess' => 'דער באַניצער־נאָמען "<nowiki>$1</nowiki>" איז געווארן געענדערט צו "<nowiki>$2</nowiki>".',
	'renamewiki_user-page-exists' => "דער בלאַט $1 עקזיסטירט שוין און מ'קען אים נישט אויטאָמאַטיש איבערשרײַבן.",
	'renamewiki_user-page-moved' => 'דער בלאַט $1 איז געווארן באַוועגט צו $2.',
	'renamewiki_user-page-unmoved' => 'מען קען נישט באַוועגן דעם בלאַט $1 צו $2.',
	'renamewiki_userlogpage' => 'באַניצער נאָמען-טויש לאָג-בוך',
	'renamewiki_userlogpagetext' => 'דאָס איז אַ לאג פֿון ענדערונגען צו באַניצער־נעמען.',
	'renamewiki_userlogentry' => 'מ\'האט דעם נאָמען $1 געענדערט צו "$2"',
	'renamewiki_user-log' => '{{PLURAL:$1|1 רעדאַקטירונג|$1 רעדאַקטירונגען}}. גרונד: $2',
	'renamewiki_user-move-log' => 'אויטאמאַטיש באַוועגט בלאַט דורך ענדערן באַניצער־נאָמען פֿון "[[wiki_user:$1|$1]]" צו "[[wiki_user:$2|$2]]"',
	'right-renamewiki_user' => 'בײַטן באַניצער נעמען',
	'renamewiki_user-renamed-notice' => 'דער נאָמען פֿון דעם באַניצער איז געענדערט געווארן.
דער ענדערן נעמען לאגבוך ווערט געוויזן אונטן.',
);

/** Yoruba (Yorùbá)
 * @author Demmy
 */
$messages['yo'] = array(
	'renamewiki_userold' => 'Orúkọ oníṣe ìsinsìnyí:',
	'renamewiki_usernew' => 'Orúkọ oníṣe tuntun:',
	'renamewiki_userwarnings' => 'Àwọn ìkìlọ̀:',
	'renamewiki_usersubmit' => 'Fúnsílẹ̀',
	'renamewiki_usererrordoesnotexist' => 'Oníṣe "<nowiki>$1</nowiki>" kò sí.',
	'renamewiki_usererrorexists' => 'Oníṣe "<nowiki>$1</nowiki>" tilẹ̀ wà tẹ́lẹ̀.',
	'renamewiki_userlogentry' => 'ṣàtúnsọlórúkọ $1 sí $2',
	'renamewiki_user-log' => '{{PLURAL:$1|Àtúnṣe 1|Àwọn àtúnṣe $1}}. Ìdíẹ̀: $2',
);

/** Cantonese (粵語) */
$messages['yue'] = array(
	'renamewiki_user' => '改用戶名',
	'renamewiki_user-desc' => "幫用戶改名 (需要 ''renamewiki_user'' 權限)",
	'renamewiki_userold' => '現時嘅用戶名:',
	'renamewiki_usernew' => '新嘅用戶名:',
	'renamewiki_userreason' => '改名嘅原因:',
	'renamewiki_usermove' => '搬用戶頁同埋佢嘅對話頁（同埋佢哋嘅細頁）到新名',
	'renamewiki_userwarnings' => '警告:',
	'renamewiki_userconfirm' => '係，改呢個用戶名',
	'renamewiki_usersubmit' => '遞交',
	'renamewiki_usererrordoesnotexist' => '用戶"<nowiki>$1</nowiki>"唔存在',
	'renamewiki_usererrorexists' => '用戶"<nowiki>$1</nowiki>"已經存在',
	'renamewiki_usererrorinvalid' => '用戶名"<nowiki>$1</nowiki>"唔正確',
	'renamewiki_user-error-request' => '響收到請求嗰陣出咗問題。
請返去再試過。',
	'renamewiki_user-error-same-wiki_user' => '你唔可以改一位用戶係同之前嘅嘢一樣。',
	'renamewiki_usersuccess' => '用戶"<nowiki>$1</nowiki>"已經改咗名做"<nowiki>$2</nowiki>"',
	'renamewiki_user-page-exists' => '$1呢一版已經存在，唔可以自動重寫。',
	'renamewiki_user-page-moved' => '$1呢一版已經搬到去$2。',
	'renamewiki_user-page-unmoved' => '$1呢一版唔能夠搬到去$2。',
	'renamewiki_userlogpage' => '用戶改名日誌',
	'renamewiki_userlogpagetext' => '呢個係改用戶名嘅日誌',
	'renamewiki_userlogentry' => '已經幫 $1 改咗名做 "$2"',
	'renamewiki_user-log' => '擁有$1次編輯。 原因: $2',
	'renamewiki_user-move-log' => '當由"[[wiki_user:$1|$1]]"改名做"[[wiki_user:$2|$2]]"嗰陣已經自動搬咗用戶頁',
	'right-renamewiki_user' => '改用戶名',
);

/** Simplified Chinese (中文（简体）‎)
 * @author Bencmq
 * @author Gaoxuewei
 * @author Gzdavidwong
 * @author Hydra
 * @author Liangent
 * @author PhiLiP
 * @author Xiaomingyan
 * @author Yfdyh000
 */
$messages['zh-hans'] = array(
	'renamewiki_user' => '更改用户名',
	'renamewiki_user-linkoncontribs' => '更改用户名',
	'renamewiki_user-linkoncontribs-text' => '更改该用户名',
	'renamewiki_user-desc' => "添加更改用户名的[[Special:Renamewiki_user|特殊页面]]（需要''renamewiki_user''权限）",
	'renamewiki_userold' => '当前用户名：',
	'renamewiki_usernew' => '新用户名：',
	'renamewiki_userreason' => '更名原因：',
	'renamewiki_usermove' => '移动用户和讨论页面（和子页面）至新用户名',
	'renamewiki_usersuppress' => '不创建至新用户名的重定向页',
	'renamewiki_userreserve' => '封锁旧用户名，使其不能在未来使用',
	'renamewiki_userwarnings' => '警告：',
	'renamewiki_userconfirm' => '是，更改用户名',
	'renamewiki_usersubmit' => '提交',
	'renamewiki_user-submit-blocklog' => '显示用户的封禁日志',
	'renamewiki_usererrordoesnotexist' => '用户“<nowiki>$1</nowiki>”不存在。',
	'renamewiki_usererrorexists' => '用户“<nowiki>$1</nowiki>”已经存在。',
	'renamewiki_usererrorinvalid' => '用户名“<nowiki>$1</nowiki>”无效。',
	'renamewiki_user-error-request' => '接收申请出错。请返回重试。',
	'renamewiki_user-error-same-wiki_user' => '你不可以填写原来的用户名。',
	'renamewiki_usersuccess' => '用户“<nowiki>$1</nowiki>”已更名为“<nowiki>$2</nowiki>”。',
	'renamewiki_user-page-exists' => '页面$1己经存在，不能被自动覆盖。',
	'renamewiki_user-page-moved' => '页面$1已移动至$2。',
	'renamewiki_user-page-unmoved' => '页面$1不能移动至$2。',
	'renamewiki_userlogpage' => '用户更名日志',
	'renamewiki_userlogpagetext' => '这是用户名更改的日志。',
	'renamewiki_userlogentry' => '更名$1为“$2”',
	'renamewiki_user-log' => '$1个编辑。原因：$2',
	'renamewiki_user-move-log' => '当更改用户名“[[wiki_user:$1|$1]]”为“[[wiki_user:$2|$2]]”时自动移动页面',
	'action-renamewiki_user' => '重命名用户',
	'right-renamewiki_user' => '更改用户名',
	'renamewiki_user-renamed-notice' => '本用户已更名。下面提供更名日志以供参考。',
);

/** Traditional Chinese (中文（繁體）‎)
 * @author Gaoxuewei
 * @author Horacewai2
 * @author Liangent
 * @author Mark85296341
 * @author Simon Shek
 * @author Waihorace
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'renamewiki_user' => '用戶重新命名',
	'renamewiki_user-linkoncontribs' => '用戶重新命名',
	'renamewiki_user-linkoncontribs-text' => '重命名此用戶',
	'renamewiki_user-desc' => "新增一個[[Special:Renamewiki_user|特殊頁面]]來重命名用戶（需要''renamewiki_user''權限）",
	'renamewiki_userold' => '現時用戶名：',
	'renamewiki_usernew' => '新的使用者名稱：',
	'renamewiki_userreason' => '重新命名的原因：',
	'renamewiki_usermove' => '移動用戶頁及其對話頁（包括各子頁）到新的名字',
	'renamewiki_usersuppress' => '不要建立重定向到新的名稱',
	'renamewiki_userreserve' => '封禁舊使用者名稱，使之不能在日後使用',
	'renamewiki_userwarnings' => '警告：',
	'renamewiki_userconfirm' => '是，為用戶重新命名',
	'renamewiki_usersubmit' => '提交',
	'renamewiki_user-submit-blocklog' => '顯示用戶的封禁日誌',
	'renamewiki_usererrordoesnotexist' => '用戶「<nowiki>$1</nowiki>」不存在',
	'renamewiki_usererrorexists' => '用戶「<nowiki>$1</nowiki>」已存在',
	'renamewiki_usererrorinvalid' => '用戶名「<nowiki>$1</nowiki>」不可用',
	'renamewiki_user-error-request' => '在收到請求時出現問題。
請回去重試。',
	'renamewiki_user-error-same-wiki_user' => '您不可以更改一位用戶是跟之前的東西一樣。',
	'renamewiki_usersuccess' => '用戶「<nowiki>$1</nowiki>」已經更名為「<nowiki>$2</nowiki>」',
	'renamewiki_user-page-exists' => '$1 這一頁己經存在，不能自動覆寫。',
	'renamewiki_user-page-moved' => '$1 這一頁已經移動到 $2。',
	'renamewiki_user-page-unmoved' => '$1 這一頁不能移動到 $2。',
	'renamewiki_userlogpage' => '用戶名變更日誌',
	'renamewiki_userlogpagetext' => '這是用戶名更改的日誌',
	'renamewiki_userlogentry' => '已經把 $1 重新命名為「$2」',
	'renamewiki_user-log' => '擁有 $1 次編輯。 理由：$2',
	'renamewiki_user-move-log' => '當由「[[wiki_user:$1|$1]]」重新命名作「[[wiki_user:$2|$2]]」時已經自動移動用戶頁',
	'action-renamewiki_user' => '重命名用戶',
	'right-renamewiki_user' => '重新命名用戶',
	'renamewiki_user-renamed-notice' => '該用戶已被重新命名。
以下列出更改用戶名日誌以供參考。',
);

/** Zulu (isiZulu) */
$messages['zu'] = array(
	'renamewiki_usersubmit' => 'Yisa',
);

