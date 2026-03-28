<?php
class Wishlist {
    private PDO $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function isInWishlist(int $etudiantId, int $offreId): bool {
        $stmt = $this->db->prepare('SELECT 1 FROM wishlist WHERE etudiant_id = :e AND offre_id = :o LIMIT 1');
        $stmt->execute([':e' => $etudiantId, ':o' => $offreId]);
        return (bool) $stmt->fetchColumn();
    }

    /** Ajoute si absent, retire si présent. Retourne true si maintenant dans la wishlist. */
    public function toggle(int $etudiantId, int $offreId): bool {
        if ($this->isInWishlist($etudiantId, $offreId)) {
            $stmt = $this->db->prepare('DELETE FROM wishlist WHERE etudiant_id = :e AND offre_id = :o');
            $stmt->execute([':e' => $etudiantId, ':o' => $offreId]);
            return false;
        }
        $stmt = $this->db->prepare('INSERT INTO wishlist (etudiant_id, offre_id) VALUES (:e, :o)');
        $stmt->execute([':e' => $etudiantId, ':o' => $offreId]);
        return true;
    }

    /** Retourne un tableau d'IDs d'offres sauvegardées par cet étudiant. */
    public function getIdsByEtudiant(int $etudiantId): array {
        $stmt = $this->db->prepare('SELECT offre_id FROM wishlist WHERE etudiant_id = :e');
        $stmt->execute([':e' => $etudiantId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /** Retourne les offres complètes (avec nom entreprise) sauvegardées par cet étudiant. */
    public function getOffresByEtudiant(int $etudiantId): array {
        $stmt = $this->db->prepare('
            SELECT o.*, ent.nom AS entreprise_nom
            FROM wishlist w
            JOIN offres o   ON o.id   = w.offre_id
            JOIN entreprises ent ON ent.id = o.entreprise_id
            WHERE w.etudiant_id = :e
            ORDER BY w.created_at DESC
        ');
        $stmt->execute([':e' => $etudiantId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
