<?php

/**
 * contains constants representing different operation errors
 * @author Habbes
 *
 */
class OperationError
{
	//User errors
	const NOT_FOUND = "NotFound";
	const USER_NOT_FOUND = "UserNotFound";
	const USER_USERNAME_INVALID = "UsernameInvalid";
	const USER_PASSWORD_INVALID = "PasswordInvalid";
	const USER_PASSWORD_INCORRECT = "PasswordIncorrect";
	const USER_PASSWORDS_DONT_MATCH = "PasswordsDontMatch";
	const USER_EMAIL_INVALID = "EmailInvalid";
	const USER_USERNAME_UNAVAILABLE = "UsernameUnavailable";
	const USER_EMAIL_UNAVAILABLE = "EmailUnavailable";
	const USER_EMAIL_NOT_ACTIVATED = "EmailNotActivated";
	const USER_FIRST_NAME_EMPTY = "FirstNameEmpty";
	const USER_LAST_NAME_EMPTY = "LastNameEmpty";
	const USER_TYPE_INVALID = "UserTypeInvalid";
	const USER_ADDRESS_EMPTY = "AddressEmpty";
	const USER_RESIDENCE_EMPTY = "ResidenceEmpty";
	const USER_NATIONALITY_EMPTY = "NationalityEmpty";
	const USER_GENDER_INVALID = "UserGenderInvalid";
	const COLLAB_AREA_INVALID = "CollabAreaInvalid";
	const THEMATIC_AREA_INVALID = "ThematicAreaInvalid";
	const PAPER_GROUP_INVALID = "PaperGroupInvalid";
	const EMAIL_ACTIVATION_INVALID = "EmailActivationInvalid";
	const INVITATION_INVALID = "InvitationInvalid";
	const AUTHOR_NAME_EMPTY = "AuthorNameEmpty";
	//paper errors
	const PAPER_TITLE_EMPTY = "PaperTitleEmpty";
	const PAPER_LANGUAGE_EMPTY = "PaperLanguageEmpty";
	const PAPER_COUNTRY_EMPTY = "PaperCountryEmpty";
	const PAPER_MAX_AUTHORS_REACHED = "PaperMaxAuthorsReached";
	//vet review errors
	const VET_INVALID_VERDICT = "VetInvalidVerdict";
	const VET_COMMENTS_EMPTY = "VetCommentsEmpty";
	//review request
	const REVIEW_REQUEST_INVALID = "ReviewRequestInvalid";
	const REVIEW_REQUEST_DUPLICATE_PENDING = "ReviewRequestDuplicatePending";
	//review
	const REVIEW_VERDICT_INVALID = "ReviewVerdictInvalid";
	const REVIEW_COMMENTS_TO_ADMIN_EMPTY = "ReviewCommentsToAdminEmpty";
	const REVIEW_COMMENTS_TO_RESEARCHER_EMPTY = "ReviewCommentsToResearcherEmpty";
	
	
	
	
}