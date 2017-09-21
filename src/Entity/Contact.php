<?php


namespace Entity;

/**
 * Contact
 * 
 * @Entity
 * @Table(name="t_contact")
 */
class Contact
{
    /**
     * @Id
     * @Column(type="integer",name="id")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     *@Column(name="nom", type="string") 
     */
    protected $nom;
    
    /**
     *@Column(type="string", name="prenom")
     */
    protected $prenom;
    
    /**
    *@Column(type="string", name="email")
    */
    protected $mail;
    
    /**
     * @Column (type="string", name="sujet")
     */
    protected $sujet;
    
    /**
    *@Column(type="string", name="message")
    */
    protected $message;
    
    /**
     * 
     *@Column(type="date", name="date_contact")
     */
    protected $date;
    
    /**
     * 
     * @Column(type="boolean", name="archive")
     */
    protected $archive;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }
    
        public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
        return $this;
    }
    
        public function getMail() {
        return $this->mail;
    }

    public function setMail($mail) {
        $this->mail = $mail;
        return $this;
    }
    
    public function getSujet () {
        return $this->sujet;
    }
    
    public function setSujet ($sujet) {
        $this->sujet = $sujet;
        return $this;
    }
    
    public function getMessage() {
        return $this->message;
    }
    
    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }
    
    public function getDate() {
        return $this->date;
    }
    
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }
    
    public function getArchive () {
        return $this->archive;
    }
    
    public function setArchive ($archive) {
        $this->archive = $archive;
        return $this;
    }
}  