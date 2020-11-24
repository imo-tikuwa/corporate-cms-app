<?php
/** サイト名 */
const SITE_NAME = 'CorporateCMS';

/** サイト名(短) */
const SITE_NAME_SHORT = 'CC';

/** スーパーユーザーのアカウントID(権限チェック不要で全ての機能にアクセス可能) */
const SUPER_USER_ID = 1;

/** Read権限 */
const ROLE_READ = 'READ';

/** Write権限 */
const ROLE_WRITE = 'WRITE';

/** Delete権限 */
const ROLE_DELETE = 'DELETE';

/** CsvExport権限 */
const ROLE_CSV_EXPORT = 'CSV_EXPORT';

/** CsvImport権限 */
const ROLE_CSV_IMPORT = 'CSV_IMPORT';

/** ExcelExport権限 */
const ROLE_EXCEL_EXPORT = 'EXCEL_EXPORT';

/** ExcelImport権限 */
const ROLE_EXCEL_IMPORT = 'EXCEL_IMPORT';

/** indexアクション */
const ACTION_INDEX = 'index';

/** viewアクション */
const ACTION_VIEW = 'view';

/** addアクション */
const ACTION_ADD = 'add';

/** editアクション */
const ACTION_EDIT = 'edit';

/** deleteアクション */
const ACTION_DELETE = 'delete';

/** csvExportアクション */
const ACTION_CSV_EXPORT = 'csvExport';

/** csvImportアクション */
const ACTION_CSV_IMPORT = 'csvImport';

/** excelExportアクション */
const ACTION_EXCEL_EXPORT = 'excelExport';

/** excelImportアクション */
const ACTION_EXCEL_IMPORT = 'excelImport';

/** 権限エラーメッセージ */
const MESSAGE_AUTH_ERROR = '権限エラーが発生しました';