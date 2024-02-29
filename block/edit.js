/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { useBlockProps } from '@wordpress/block-editor';
/**
 * WordPress components that create the necessary UI elements for the block
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-components/
 */
 import { RadioControl } from '@wordpress/components';
 import { SelectControl } from '@wordpress/components';
 import { TextControl } from '@wordpress/components';
 
/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';


/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
  const blockProps = useBlockProps();
  //+++++++++++++++++++++++++++++++++++++++++++++
  // may be useful for client side rendering
  // const posts = useSelect((select) => {
  //   return select("core").getEntityRecords("postType", "post");
  // }, []);
  //+++++++++++++++++++++++++++++++++++++++++++++
  return (
		<div { ...blockProps }>
      <RadioControl
        label = { "Please select an ORCiD section" }
        options = { [
          { "label": "Education", "value": "education" },
          { "label": "Employment", "value": "employment" },
          { "label": "Works", "value": "works" },
          { "label": "Fundings", "value": "fundings" },
          { "label": "Header", "value": "header" },
          { "label": "Personal", "value": "personal" }
        ] }
        selected = { attributes.section }
				onChange = { 
          ( val ) => {
            if( attributes.section != "works"){
              attributes.worksType = "all";
              attributes.worksStartYear = "1900";
            }
            setAttributes( { section: val } ) 
          } 
        }
      >
      </RadioControl>

      <SelectControl
        label = { "Please select the type of works" }
        labelPosition = { "side" }
        multiple = { false }
        size = { "default" }
        value = { attributes.worksType }
				onChange = { ( val ) => setAttributes( { "worksType": val } ) }
        options = { [
          { "label": "ALL", "value": "all" },
          { "label": "ANNOTATION", "value": "annotation" },
          { "label": "ARTISTIC_PERFORMANCE", "value": "artistic-performance" },
          { "label": "BOOK_CHAPTER", "value": "book-chapter" },
          { "label": "BOOK_REVIEW", "value": "book-review" },
          { "label": "BOOK", "value": "book" },
          { "label": "CONFERENCE_ABSTRACT", "value": "conference-abstract" },
          { "label": "CONFERENCE_PAPER", "value": "conference-paper" },
          { "label": "CONFERENCE_POSTER", "value": "conference-poster" },
          { "label": "DATA_MANAGEMENT_PLAN", "value": "data-management-plan" },
          { "label": "DATA_SET", "value": "data-set" },
          { "label": "DICTIONARY_ENTRY", "value": "dictionary-entry" },
          { "label": "DISCLOSURE", "value": "disclosure" },
          { "label": "DISSERTATION_THESIS", "value": "dissertation-thesis" },
          { "label": "EDITED_BOOK", "value": "edited-book" },
          { "label": "ENCYCLOPEDIA_ENTRY", "value": "encyclopedia-entry" },
          { "label": "INVENTION", "value": "invention" },
          { "label": "JOURNAL_ARTICLE", "value": "journal-article" },
          { "label": "JOURNAL_ISSUE", "value": "journal-issue" },
          { "label": "LECTURE_SPEECH", "value": "lecture-speech" },
          { "label": "LICENSE", "value": "license" },
          { "label": "MAGAZINE_ARTICLE", "value": "magazine-article" },
          { "label": "MANUAL", "value": "manual" },
          { "label": "NEWSLETTER_ARTICLE", "value": "newsletter-article" },
          { "label": "NEWSPAPER_ARTICLE", "value": "newspaper-article" },
          { "label": "ONLINE_RESOURCE", "value": "online-resource" },
          { "label": "OTHER", "value": "other" },
          { "label": "PATENT", "value": "patent" },
          { "label": "PHYSICAL_OBJECT", "value": "physical-object" },
          { "label": "PREPRINT", "value": "preprint" },
          { "label": "REGISTERED_COPYRIGHT", "value": "registered-copyright" },
          { "label": "REVIEW", "value": "review" },
          { "label": "REPORT", "value": "report" },
          { "label": "RESEARCH_TECHNIQUE", "value": "research-technique" },
          { "label": "RESEARCH_TOOL", "value": "research-tool" },
          { "label": "SOFTWARE", "value": "software" },
          { "label": "SPIN_OFF_COMPANY", "value": "spin-off-company" },
          { "label": "STANDARDS_AND_POLICY", "value": "standards-and-policy" },
          { "label": "SUPERVISED_STUDENT_PUBLICATION", "value": "supervised-student-publication" },
          { "label": "TECHNICAL_STANDARD", "value": "technical-standard" },
          { "label": "TEST", "value": "test" },
          { "label": "TRADEMARK", "value": "trademark" },
          { "label": "TRANSLATION", "value": "translation" },
          { "label": "WEBSITE", "value": "website" },
          { "label": "WORKING_PAPER", "value": "working-paper" },
          { "label": "UNDEFINED", "value": "undefined" }
        ] }
      >
      </SelectControl>

      <TextControl
        label = { "Please select the start publishing year for works" }
        value={ attributes.worksStartYear }
        onChange={ ( val ) => setAttributes( { "worksStartYear": val } ) }
        />
		</div>
	);
}
